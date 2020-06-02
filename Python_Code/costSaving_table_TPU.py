# -*- coding: utf-8 -*-
"""
Created on Wed May 13 02:05:54 2020

@author: pamareel
"""

import pandas as pd
import pyodbc
import math
import numpy as np

class dt:
    def __init__(self):
        #connect to PAC DB
        self.conn = pyodbc.connect('Driver={SQL Server};'
                                   'Server=LAPTOP-EBOH4917\MSSQLSERVER2019;'
                                   'Database=PAC;'
                                   'Trusted_Connection=yes;')
        self.cursor = self.conn.cursor()
        
        self.year = pd.read_sql('SELECT DISTINCT BUDGET_YEAR FROM drugs where BUDGET_YEAR IS NOT NULL order by BUDGET_YEAR', self.conn)
        self.method_list = pd.read_sql('SELECT DISTINCT REAL_METHOD_NAME FROM drugs', self.conn)

        self.costSaving_full_hos_result = pd.DataFrame({'BUDGET_YEAR' : [], 'GPU_ID': [], 'GPU_NAME': [], 'TPU_ID': [], 'TPU_NAME': [], 'Method': [], 'DEPT_ID': [], 'DEPT_NAME': [], 'Total_Amount': [], 'wavg_unit_price': [], 'suggested_unit_price': [], 'Real_Total_Spend': [], 'suggested_spending': [], 'Potential_Saving_Cost': [], 'Percent_saving': [], 'Qi_Qmax': []})
        self.costSaving_TPU_full_result = pd.DataFrame({'BUDGET_YEAR' : [], 'GPU_ID': [], 'GPU_NAME': [], 'TPU_ID': [], 'TPU_NAME': [], 'Method': [], 'Real_Total_Spend': [], 'Suggested_Total_Spend': [], 'Potential_Saving_Cost': [], 'Percent_saving': []})

        for index, row in self.year.iterrows():
            self.y = row['BUDGET_YEAR']
            for index, row in self.method_list.iterrows():
                self.mms = row['REAL_METHOD_NAME']
        
                #get TPU ID and TPU Description list & delete the duplicate(by using group by)
                self.TPU = pd.read_sql("SELECT TPU_ID, TPU_NAME FROM drugs where BUDGET_YEAR = "+str(self.y)+" AND REAL_METHOD_NAME = '"+str(self.mms)+"' GROUP BY TPU_ID, TPU_NAME, BUDGET_YEAR", self.conn)
                self.TPU = self.TPU[pd.notnull(self.TPU['TPU_ID'])]
                if self.TPU.empty == False:
                    #set index to be TPU ID
                    self.TPU_list = self.TPU.set_index('TPU_ID')
            
                    #init
                    self.eachTPU = dict()
                    self.maxAmount = dict()
                    self.maxUnitPrice = dict()
                    self.minUnitPrice = dict()
                    #find max & min value of each TPU
                    for index, row in self.TPU_list.iterrows():
                        self.queryMaxAmount(index, self.y, self.mms)
                        self.maxAmount[index] = self.round_half_up(self.resultMaxAmount, 8)
                        
                        self.queryMaxUnitPrice(index, self.y, self.mms)
                        self.maxUnitPrice[index] = self.round_half_up(self.resultMaxUnitPrice, 8)
                        
                        self.queryMinUnitPrice(index, self.y, self.mms)
                        self.minUnitPrice[index] = self.round_half_up(self.resultMinUnitPrice, 8)
                    
                    #get DEPT_ID and DEPT_NAME list & delete the duplicate(by using group by)
                    self.DEPT = pd.read_sql('SELECT DEPT_ID, DEPT_NAME FROM drugs GROUP BY DEPT_ID, DEPT_NAME, BUDGET_YEAR HAVING (BUDGET_YEAR = ' + str(self.y) + ') AND ((DEPT_ID IS NOT NULL) OR (DEPT_NAME IS NOT NULL))', self.conn)
                    #set index to be DEPT_ID
                    self.DEPT_list = self.DEPT.copy()
                    
                    #create result table
                    self.PAC = pd.DataFrame({'BUDGET_YEAR' : [], 'GPU_ID': [], 'GPU_NAME': [], 'TPU_ID': [], 'TPU_NAME': [], 'Method' : [], 'DEPT_ID': [], 'DEPT_NAME': [], 'ServicePlanType': [], 'PROVINCE_NAME': [], 'PROVINCE_EN': [], 'Pcode': [], 'Region': [], 'IP': [], 'OP': [], 'Total_Amount': [], 'wavg_unit_price': [], 'Total_Spend': [], 'PAC_value': [], 'Qi_Qmax': []})
                    self.PAC_full = pd.DataFrame({'BUDGET_YEAR' : [], 'GPU_ID': [], 'GPU_NAME': [], 'TPU_ID': [], 'TPU_NAME': [], 'Method' : [], 'DEPT_ID': [], 'DEPT_NAME': [], 'ServicePlanType': [], 'PROVINCE_NAME': [], 'PROVINCE_EN': [], 'Pcode': [], 'Region': [], 'IP': [], 'OP': [], 'Total_Amount': [], 'wavg_unit_price': [], 'Total_Spend': [], 'PAC_value': [], 'Qi_Qmax': []})
                    
                    #extract hospital information
                    self.Hospital = pd.read_sql('SELECT เขต, ชื่อจังหวัด, รหัสหน่วยงาน, ชื่อหน่วยงาน, ประเภทServicePlan, IP_2561, OP_Visit_2561 FROM patient_num', self.conn)
                    self.hosType = dict()
                    self.hosRegion = dict()
                    self.hosIP = dict()
                    self.hosOP = dict()
                    self.hID_list = []
                    for index, row in self.Hospital.iterrows():
                        hID = row['รหัสหน่วยงาน']
                        hType = row['ประเภทServicePlan']
                        hRegion = row['เขต']
                        hIP = row['IP_2561']
                        hOP = row['OP_Visit_2561']
                        self.hosType[hID] = hType
                        self.hosRegion[hID] = hRegion
                        self.hosIP[hID] = hIP
                        self.hosOP[hID] = hOP
                        self.hID_list.append(hID)
                        
                    #for hospital don't have information about type, IP, OP
                    #so add only region
                    self.region_province = pd.read_sql('select * from [Region-Province]', self.conn)
                    self.region_province_list = self.region_province.set_index('PROVINCE_NAME')
                    
                    self.avg_PAC = dict()
                    #self.countTPU_u = dict()
                    self.totalPurchaseCost_u = dict()
                    
                    #self.countTPUelement = pd.DataFrame({'GPU_ID': [], 'GPU_NAME': [], 'Count_TPU': []})
                    for index, row in self.TPU_list.iterrows():
                        tem = []
                        TPU = index
                        sql = "SELECT BUDGET_YEAR, REAL_METHOD_NAME, GPU_ID, GPU_NAME, TPU_ID, TPU_NAME, PROVINCE_NAME, DEPT_ID, DEPT_NAME, SUM(Real_Amount) AS Total_Amount, SUM(Real_Amount * [Real_Unit price]) / SUM(Real_Amount) AS Weighted_Avg_unit_price, SUM(Real_Amount)*(SUM(Real_Amount * [Real_Unit price]) / SUM(Real_Amount)) AS Total_price FROM drugs where BUDGET_YEAR = " + str(self.y) + " AND REAL_METHOD_NAME =  '"+str(self.mms)+"' AND TPU_ID = " + str(TPU) + " GROUP BY BUDGET_YEAR, REAL_METHOD_NAME, DEPT_ID, DEPT_NAME, PROVINCE_NAME, GPU_ID, GPU_NAME, TPU_ID, TPU_NAME ORDER BY Weighted_Avg_unit_price DESC, DEPT_ID"
                        self.TPUtemp = pd.read_sql(sql, self.conn)
                        hosIdMinPrice_list = []
                        hosIdMethodMinPrice_list = []
                        hosNameMinPrice_list = []
                        hosNameMethodMinPrice_list = []
                        maxPAC = 0
                        
                        TotalPurchaseCost = 0
                        PurchaseCost = 0
                        TotalPac = 0
                        count_numPAC = 0
            
                        #count PAC value
                        sql_PAC_count = "SELECT Count(DISTINCT DEPT_ID) FROM drugs where (REAL_METHOD_NAME = '" + str(self.mms) + "') AND (TPU_ID = " + str(TPU) + ") AND (BUDGET_YEAR = " + str(self.y) + ") GROUP BY BUDGET_YEAR, GPU_ID, GPU_NAME, TPU_ID, TPU_NAME"
                        self.countPAC = pd.read_sql(sql_PAC_count, self.conn)
                        for index, row in self.TPUtemp.iterrows():
                            wavg = row['Weighted_Avg_unit_price']
                           
                            mwavg = self.round_half_up(wavg, 8)
                            self.PAC['BUDGET_YEAR'], self.PAC['Method'], self.PAC['GPU_ID'], self.PAC['GPU_NAME'], self.PAC['TPU_ID'], self.PAC['TPU_NAME'], self.PAC['PROVINCE_NAME'], self.PAC['DEPT_ID'], self.PAC['DEPT_NAME'] = [[row['BUDGET_YEAR']], [row['REAL_METHOD_NAME']], [row['GPU_ID']], [row['GPU_NAME']], [row['TPU_ID']], [row['TPU_NAME']], row['PROVINCE_NAME'], row['DEPT_ID'], row['DEPT_NAME']]
            
                            #hospital information
                            #มันพัง เพราะเลขdept_id หายไป2ตำแหน่ง
                            deptt = row['DEPT_ID']/100
                            if deptt in self.hID_list:
                                ht = self.hosType[deptt]
                                hr = self.hosRegion[deptt]
                                hi = self.hosIP[deptt]
                                ho = self.hosOP[deptt]
                            else:
                                ht = None
                                hr = None
                                hi = None
                                ho = None
                                
                            self.PAC['ServicePlanType'] = ht
                            self.PAC['Region'] = self.region_province_list.loc[row['PROVINCE_NAME'], 'Region']
                            self.PAC['Pcode'] = self.region_province_list.loc[row['PROVINCE_NAME'], 'Pcode']
                            self.PAC['PROVINCE_EN'] = self.region_province_list.loc[row['PROVINCE_NAME'], 'PROVINCE_EN']
                            self.PAC['IP'] = hi
                            self.PAC['OP'] = ho
                            
                            self.PAC['Total_Amount'], self.PAC['wavg_unit_price'] = [[self.round_half_up(row['Total_Amount'], 8)], [mwavg]]
                            self.PAC['Total_Spend'] = self.round_half_up(row['Total_price'],8)
                            
                            PACvalue = -(math.log(self.round_half_up(row['Weighted_Avg_unit_price'],8)/self.maxUnitPrice[TPU]))/(self.round_half_up(row['Total_Amount'],8)/self.maxAmount[TPU])
                            PACvalue = self.round_half_up(PACvalue,8)
                            tem.append(PACvalue)
                            
                            #calculate PAC value
                            if mwavg == self.minUnitPrice[TPU]:
                                if math.isnan(row['DEPT_ID']) :
                                    hosNameMinPrice_list.append(row['DEPT_NAME'])
                                    hosNameMethodMinPrice_list.append(row['REAL_METHOD_NAME'])
                                else:
                                    hosIdMinPrice_list.append(row['DEPT_ID'])
                                    hosIdMethodMinPrice_list.append(row['REAL_METHOD_NAME'])
                                
                            self.PAC['PAC_value'] = PACvalue
                            self.PAC['Qi_Qmax'] = self.round_half_up(row['Total_Amount'],8)/self.maxAmount[TPU]
                            
                            self.PAC_full = self.PAC_full.append(self.PAC)
                            
                            #for cost saving
                            PurchaseCost = self.round_half_up(row['Total_price'],8)
                            TotalPurchaseCost = TotalPurchaseCost + PurchaseCost
            
                            TotalPac = TotalPac + PACvalue
                            count_numPAC = count_numPAC + 1
                        
                        #self.countTPUelement = self.countTPUelement.append(self.countTPU)
                        #self.countTPU_u[GPU] = self.countTPU['Count_TPU']
                        self.totalPurchaseCost_u[TPU] = TotalPurchaseCost
                        
                        maxPAC = max(tem)
                        self.PAC_full.index = range(len(self.PAC_full))
            
                        i=0
                        for y in hosIdMinPrice_list:
                            if y != None:
                                resultIndex = self.PAC_full.loc[(self.PAC_full['DEPT_ID'] == y) & (self.PAC_full['TPU_ID'] == TPU) & (self.PAC_full['Method'] == hosIdMethodMinPrice_list[i])].index.values
                                if isinstance(self.PAC_full.loc[resultIndex, 'PAC_value'].values, np.ndarray):
                                    TotalPac = TotalPac - self.PAC_full.loc[resultIndex, 'PAC_value'].values.item() + maxPAC
                                else:
                                    TotalPac = TotalPac - self.PAC_full.loc[resultIndex, 'PAC_value'].values + maxPAC
                                i=i+1
                                self.PAC_full.loc[resultIndex, 'PAC_value'] = maxPAC
                        i=0
                        for zz in hosNameMinPrice_list:
                                resultIndex = self.PAC_full.loc[(self.PAC_full['DEPT_NAME'] == zz) & (self.PAC_full['TPU_ID'] == TPU) & (self.PAC_full['Method'] == hosNameMethodMinPrice_list[i])].index.values
                                if isinstance(self.PAC_full.loc[resultIndex, 'PAC_value'].values, np.ndarray):
                                    TotalPac = TotalPac - self.PAC_full.loc[resultIndex, 'PAC_value'].values.item() + maxPAC
                                else:
                                    TotalPac = TotalPac - self.PAC_full.loc[resultIndex, 'PAC_value'].values + maxPAC
                                i=i+1
                                self.PAC_full.loc[resultIndex, 'PAC_value'] = maxPAC
                       
                        self.avg_PAC[TPU] = TotalPac/count_numPAC
                    
                    self.costSaving_hos = pd.DataFrame({'BUDGET_YEAR' : [], 'GPU_ID': [], 'GPU_NAME': [], 'TPU_ID': [], 'TPU_NAME': [], 'Method': [], 'DEPT_ID': [], 'DEPT_NAME': [], 'Total_Amount': [], 'wavg_unit_price': [], 'suggested_unit_price': [], 'Real_Total_Spend': [], 'suggested_spending': [], 'Potential_Saving_Cost': [], 'Percent_saving': [], 'Qi_Qmax': []})
                    self.costSaving_full_hos = pd.DataFrame({'BUDGET_YEAR' : [], 'GPU_ID': [], 'GPU_NAME': [], 'TPU_ID': [], 'TPU_NAME': [], 'Method': [], 'DEPT_ID': [], 'DEPT_NAME': [], 'Total_Amount': [], 'wavg_unit_price': [], 'suggested_unit_price': [], 'Real_Total_Spend': [], 'suggested_spending': [], 'Potential_Saving_Cost': [], 'Percent_saving': [], 'Qi_Qmax': []})
                    
                    
                    for index, row in self.PAC_full.iterrows():
                        year = self.PAC_full.loc[index, 'BUDGET_YEAR']
                        GPU_ID = self.PAC_full.loc[index, 'GPU_ID']
                        GPU_NAME = self.PAC_full.loc[index, 'GPU_NAME']
                        TPU_ID = self.PAC_full.loc[index, 'TPU_ID']
                        TPU_NAME = self.PAC_full.loc[index, 'TPU_NAME']
                        Method = self.PAC_full.loc[index, 'Method']
                        total_s = self.PAC_full.loc[index, 'Total_Spend']
                        #count_t = self.countTPU_u[GPU_ID][0]
                        
                        self.costSaving_hos['DEPT_ID'], self.costSaving_hos['DEPT_NAME'] = [[row['DEPT_ID']], [row['DEPT_NAME']]]
                        self.costSaving_hos['Total_Amount'] = row['Total_Amount']
                        self.costSaving_hos['BUDGET_YEAR'], self.costSaving_hos['GPU_ID'], self.costSaving_hos['GPU_NAME'], self.costSaving_hos['TPU_ID'], self.costSaving_hos['TPU_NAME'], self.costSaving_hos['Method'] = [[year], [GPU_ID], [GPU_NAME], [TPU_ID], [TPU_NAME], [Method]]
                        self.costSaving_hos['Real_Total_Spend'] = [total_s]
                        
                        Pmin = self.minUnitPrice[TPU_ID]
                        Pmax = self.maxUnitPrice[TPU_ID]
                        
                        e = (math.exp((-self.avg_PAC[TPU_ID])*(row['Qi_Qmax']))) 
                        
                        if e < Pmin/Pmax :
                            e = Pmin/Pmax
                            
                        suggested_price = e*Pmax
                        self.costSaving_hos['Qi_Qmax'] = row['Qi_Qmax']
                        self.costSaving_hos['wavg_unit_price'] = row['wavg_unit_price']
                        self.costSaving_hos['suggested_unit_price'] = suggested_price
                        if row['wavg_unit_price'] < suggested_price:
                            self.costSaving_hos['suggested_spending'] = row['wavg_unit_price']*row['Total_Amount']
                        else:
                            self.costSaving_hos['suggested_spending'] = suggested_price*row['Total_Amount']
                        save_cost = row['Total_Spend'] - (suggested_price*row['Total_Amount'])
                        self.costSaving_hos['Potential_Saving_Cost'] = save_cost
                        percent_save = (save_cost*100)/(row['Total_Spend'])
                        self.costSaving_hos['Percent_saving'] = percent_save
             
                        self.costSaving_full_hos = self.costSaving_full_hos.append(self.costSaving_hos)
                    
                    self.costSaving_full_hos_2 = self.costSaving_full_hos
                    self.costSaving_full_hos = self.costSaving_full_hos.reset_index()
                    self.costSaving_TPU = pd.DataFrame({'BUDGET_YEAR' : [], 'GPU_ID': [], 'GPU_NAME': [], 'TPU_ID': [], 'TPU_NAME': [], 'Method': [], 'Real_Total_Spend': [], 'Suggested_Total_Spend': [], 'Potential_Saving_Cost': [], 'Percent_saving': []})
                    self.costSaving_TPU_full = pd.DataFrame({'BUDGET_YEAR' : [], 'GPU_ID': [], 'GPU_NAME': [], 'TPU_ID': [], 'TPU_NAME': [], 'Method': [], 'Real_Total_Spend': [], 'Suggested_Total_Spend': [], 'Potential_Saving_Cost': [], 'Percent_saving': []})
                    
                    for index, row in self.TPU_list.iterrows():
                        TPU = index
                        Sum_Total_Spend = 0
                        Sum_Potential_Saving_Cost = 0
                        Sum_Suggested_Total_Spend = 0
                        for index, row in self.costSaving_full_hos.iterrows():
                            
                            if row['TPU_ID'] == TPU:
                                year = self.costSaving_full_hos.loc[index, 'BUDGET_YEAR']
                                GPU = self.costSaving_full_hos.loc[index, 'GPU_ID']
                                GPU_NAME = self.costSaving_full_hos.loc[index, 'GPU_NAME']
                                TPU_NAME = self.costSaving_full_hos.loc[index, 'TPU_NAME']
                                Method = self.costSaving_full_hos.loc[index, 'Method']
                                
                                sc = row['Potential_Saving_Cost']
                                if row['Potential_Saving_Cost'] <0 :
                                    sc = 0
                                    
                                #print(row['Real_Total_Spend'])
                                Sum_Total_Spend = Sum_Total_Spend + row['Real_Total_Spend']
                                Sum_Potential_Saving_Cost = Sum_Potential_Saving_Cost + sc
                                Sum_Suggested_Total_Spend = Sum_Suggested_Total_Spend + row['suggested_spending']
                                
                        self.costSaving_TPU['BUDGET_YEAR'], self.costSaving_TPU['GPU_ID'], self.costSaving_TPU['GPU_NAME'], self.costSaving_TPU['TPU_ID'], self.costSaving_TPU['TPU_NAME'], self.costSaving_TPU['Method'] = [[year], [GPU], [GPU_NAME], [TPU], [TPU_NAME], [Method]]
                        self.costSaving_TPU['Real_Total_Spend'] = Sum_Total_Spend
                        self.costSaving_TPU['Suggested_Total_Spend'] = Sum_Suggested_Total_Spend
                        self.costSaving_TPU['Potential_Saving_Cost'] = Sum_Potential_Saving_Cost
                        self.costSaving_TPU['Percent_saving'] = 100*Sum_Potential_Saving_Cost/Sum_Total_Spend
                        
                        self.costSaving_TPU_full = self.costSaving_TPU_full.append(self.costSaving_TPU)
                    
                    self.costSaving_full_hos_result = self.costSaving_full_hos_result.append(self.costSaving_full_hos_2, ignore_index=True)
                    self.costSaving_TPU_full_result = self.costSaving_TPU_full_result.append(self.costSaving_TPU_full, ignore_index=True)
                    
                            
            
    def round_half_up(self, n, decimals=0):
        multiplier = 10**decimals
        return math.floor(n*multiplier + 0.5)/multiplier
   
    #global queryMaxAmount
    def queryMaxAmount(self,TPU, year, m):
        sql = "SELECT TOP (1) SUM(Real_Amount) AS Total_Amount, SUM(Real_Amount * [Real_Unit price]) / SUM(Real_Amount) AS Weighted_Avg_price, SUM(Real_Amount)*(SUM(Real_Amount * [Real_Unit price]) / SUM(Real_Amount)) AS Total_price FROM drugs where BUDGET_YEAR = " + str(year) + " AND TPU_ID = " + str(TPU) + " AND REAL_METHOD_NAME = '" + str(m)+ "' GROUP BY BUDGET_YEAR, DEPT_ID, DEPT_NAME, PROVINCE_NAME, GPU_ID, GPU_NAME, TPU_ID, TPU_NAME ORDER BY Total_Amount DESC"
        #sql = 'SELECT TOP 1 SUM(Real_Amount) AS Total_Amount FROM drugs GROUP BY BUDGET_YEAR, DEPT_ID, DEPT_NAME, PROVINCE_NAME, GPU_ID, GPU_NAME HAVING (BUDGET_YEAR = 2561) AND (GPU_ID = ' + str(GPU) + ') ORDER BY Total_Amount DESC'
        self.resultMaxAmount = pd.read_sql(sql, self.conn).at[0,'Total_Amount']
    
    #global queryMaxUnitPrice
    def queryMaxUnitPrice(self,TPU,year, m):
        sql = "SELECT TOP (1) SUM(Real_Amount) AS Total_Amount, SUM(Real_Amount * [Real_Unit price]) / SUM(Real_Amount) AS Weighted_Avg_price, SUM(Real_Amount)*(SUM(Real_Amount * [Real_Unit price]) / SUM(Real_Amount)) AS Total_price FROM drugs where BUDGET_YEAR = " + str(year) + " AND TPU_ID = " + str(TPU) + " AND REAL_METHOD_NAME = '" + str(m)+ "' GROUP BY BUDGET_YEAR, DEPT_ID, DEPT_NAME, PROVINCE_NAME, GPU_ID, GPU_NAME, TPU_ID, TPU_NAME ORDER BY Weighted_Avg_price DESC"
        self.resultMaxUnitPrice = pd.read_sql(sql, self.conn).at[0,'Weighted_Avg_price']
        
    #global queryMinUnitPrice
    def queryMinUnitPrice(self,TPU,year, m):
        sql = "SELECT TOP (1) SUM(Real_Amount) AS Total_Amount, SUM(Real_Amount * [Real_Unit price]) / SUM(Real_Amount) AS Weighted_Avg_price, SUM(Real_Amount)*(SUM(Real_Amount * [Real_Unit price]) / SUM(Real_Amount)) AS Total_price FROM drugs where BUDGET_YEAR = " + str(year) + " AND TPU_ID = " + str(TPU) + " AND REAL_METHOD_NAME = '" + str(m)+ "' GROUP BY BUDGET_YEAR, DEPT_ID, DEPT_NAME, PROVINCE_NAME, GPU_ID, GPU_NAME, TPU_ID, TPU_NAME ORDER BY Weighted_Avg_price"
        self.resultMinUnitPrice = pd.read_sql(sql, self.conn).at[0,'Weighted_Avg_price']   

        
if __name__ == "__main__":
    
    x = dt()
    PAC_full = x.PAC_full
    avg_PAC = x.avg_PAC
    #count = x.countTPUelement
    cost_saving_hos = x.costSaving_full_hos_result
    costSaving_TPU = x.costSaving_TPU_full_result
    cost_saving_hos.to_excel('CostSaving_hos_TPU.xlsx', index=False)
    costSaving_TPU.to_excel('CostSaving_TPU.xlsx', index=False)
   