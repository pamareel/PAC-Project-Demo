# -*- coding: utf-8 -*-
"""
Spyder Editor

This is a temporary script file.
"""

#import pymssql  
import pandas as pd
import pyodbc
import math

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

        self.PAC_full_result = pd.DataFrame({'BUDGET_YEAR' : [], 'Method' : [], 'GPU_ID': [], 'GPU_NAME': [], 'TPU_ID': [], 'TPU_NAME': [], 'DEPT_ID': [], 'DEPT_NAME': [], 'ServicePlanType': [], 'PROVINCE_NAME': [], 'PROVINCE_EN': [], 'Pcode': [], 'Region': [], 'IP': [], 'OP': [], 'Total_Amount': [], 'wavg_unit_price': [], 'Total_Spend': [], 'PAC_value': []})
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
                    #find max & min value of each GPU
                    for index, row in self.TPU_list.iterrows():
                        self.queryMaxAmount(index, self.y, self.mms)
                        self.maxAmount[index] = self.round_half_up(self.resultMaxAmount, 8)
                        
                        self.queryMaxUnitPrice(index, self.y, self.mms)
                        self.maxUnitPrice[index] = self.round_half_up(self.resultMaxUnitPrice, 8)
                        
                        self.queryMinUnitPrice(index, self.y, self.mms)
                        self.minUnitPrice[index] = self.round_half_up(self.resultMinUnitPrice, 8)
                    
                    #get DEPT_ID and DEPT_NAME list & delete the duplicate(by using group by)
                    #self.DEPT = pd.read_sql('SELECT DEPT_ID, DEPT_NAME FROM drugs_without_method_name GROUP BY DEPT_ID, DEPT_NAME, BUDGET_YEAR HAVING (BUDGET_YEAR = 2561) AND ((DEPT_ID IS NOT NULL) OR (DEPT_NAME IS NOT NULL))', self.conn)
                    #set index to be DEPT_ID
                    #self.DEPT_list = self.DEPT.copy()
                    
                    #create result table
                    self.PAC = pd.DataFrame({'BUDGET_YEAR' : [], 'Method' : [], 'GPU_ID': [], 'GPU_NAME': [], 'TPU_ID': [], 'TPU_NAME': [], 'DEPT_ID': [], 'DEPT_NAME': [], 'ServicePlanType': [], 'PROVINCE_NAME': [], 'PROVINCE_EN': [], 'Pcode': [], 'Region': [], 'IP': [], 'OP': [], 'Total_Amount': [], 'wavg_unit_price': [], 'Total_Spend': [], 'PAC_value': []})
                    self.PAC_full = pd.DataFrame({'BUDGET_YEAR' : [], 'Method' : [], 'GPU_ID': [], 'GPU_NAME': [], 'TPU_ID': [], 'TPU_NAME': [], 'DEPT_ID': [], 'DEPT_NAME': [], 'ServicePlanType': [], 'PROVINCE_NAME': [], 'PROVINCE_EN': [], 'Pcode': [], 'Region': [], 'IP': [], 'OP': [], 'Total_Amount': [], 'wavg_unit_price': [], 'Total_Spend': [], 'PAC_value': []})
                    
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
                    
                    #calculate PAC
                    for index, row in self.TPU_list.iterrows():
                        tem = []
                        TPU = index
                        sql = "SELECT BUDGET_YEAR, REAL_METHOD_NAME, GPU_ID, GPU_NAME, TPU_ID, TPU_NAME, PROVINCE_NAME, DEPT_ID, DEPT_NAME, SUM(Real_Amount) AS Total_Amount, SUM(Real_Amount * [Real_Unit price]) / SUM(Real_Amount) AS Weighted_Avg_unit_price, SUM(Real_Amount)*(SUM(Real_Amount * [Real_Unit price]) / SUM(Real_Amount)) AS Total_price FROM drugs where BUDGET_YEAR = " + str(self.y) + " AND REAL_METHOD_NAME =  '"+str(self.mms)+"' AND TPU_ID = " + str(TPU) + " GROUP BY BUDGET_YEAR, REAL_METHOD_NAME, DEPT_ID, DEPT_NAME, PROVINCE_NAME, GPU_ID, GPU_NAME, TPU_ID, TPU_NAME ORDER BY Weighted_Avg_unit_price DESC, DEPT_ID"
                        self.TPUtemp = pd.read_sql(sql, self.conn)
                        hosIdMinPrice_list = []
                        maxPAC = 0
                        for index, row in self.TPUtemp.iterrows():
                            wavg = row['Weighted_Avg_unit_price']
                           
                            mwavg = self.round_half_up(wavg, 8)
                            self.PAC['BUDGET_YEAR'], self.PAC['Method'], self.PAC['GPU_ID'], self.PAC['GPU_NAME'], self.PAC['PROVINCE_NAME'], self.PAC['DEPT_ID'], self.PAC['DEPT_NAME'] = [[row['BUDGET_YEAR']], [row['REAL_METHOD_NAME']], [row['GPU_ID']], [row['GPU_NAME']], row['PROVINCE_NAME'], row['DEPT_ID'], row['DEPT_NAME']]
                            self.PAC['TPU_ID'], self.PAC['TPU_NAME'] = [[row['TPU_ID']], [row['TPU_NAME']]]
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
                                hosIdMinPrice_list.append(row['DEPT_ID'])
                                
                            self.PAC['PAC_value'] = [PACvalue]
                            self.PAC_full = self.PAC_full.append(self.PAC)
            
                        maxPAC = max(tem)
                        self.PAC_full.index = range(len(self.PAC_full))
                        for y in hosIdMinPrice_list:
                            resultIndex = self.PAC_full.loc[(self.PAC_full['DEPT_ID'] == y) & (self.PAC_full['TPU_ID'] == TPU)].index.values
                            self.PAC_full.loc[resultIndex, 'PAC_value'] = maxPAC
                            
                    self.PAC_full_result = self.PAC_full_result.append(self.PAC_full, ignore_index=True)
                
    #global round_half_up
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
    PAC_full = x.PAC_full_result
    #PAC_full.to_csv('PAC_hos_drugs_2561-TPU.csv', encoding='utf-8')
    PAC_full.to_excel('PAC_hos_TPU.xlsx', sheet_name='drugs', index=False)