# -*- coding: utf-8 -*-
"""
Created on Wed Mar 11 13:06:33 2020

@author: PamareeL
"""

#import pymssql  
import pandas as pd
import pyodbc
import math

class dt:
    def __init__(self):
        #connect to PAC DB
        self.conn = pyodbc.connect('Driver={SQL Server};'
                                   'Server=DESKTOP-66A91QG\MSSQLSERVER2019;'
                                   'Database=PAC;'
                                   'Trusted_Connection=yes;')
        self.cursor = self.conn.cursor()
        
        #example of query db
        #self.xx = self.cursor.execute('SELECT GPU_ID, GPU_NAME, Real_Amount, [Real_Unit price], REAL_METHOD_NAME FROM drugs_without_method_name WHERE (GPU_ID = 651976)')
        #example of print the queried result
        #for row in self.cursor:
            #print(row)
        
        self.year = pd.read_sql('SELECT DISTINCT BUDGET_YEAR FROM drugs where BUDGET_YEAR IS NOT NULL order by BUDGET_YEAR', self.conn)
        self.method_list = pd.read_sql('SELECT DISTINCT REAL_METHOD_NAME FROM drugs', self.conn)

        
        self.PAC_full_result = pd.DataFrame({'BUDGET_YEAR' : [], 'GPU_ID': [], 'GPU_NAME': [], 'Method' : [], 'DEPT_ID': [], 'DEPT_NAME': [], 'ServicePlanType': [], 'PROVINCE_NAME': [], 'PROVINCE_EN': [], 'Pcode': [], 'Region': [], 'IP': [], 'OP': [], 'Total_Amount': [], 'wavg_unit_price': [], 'Total_Spend': [], 'PAC_value': []})
        for index, row in self.year.iterrows():
            self.y = row['BUDGET_YEAR']
            for index, row in self.method_list.iterrows():
                self.mms = row['REAL_METHOD_NAME']
                #mask = (self.tempexcel_d['BUDGET_YEAR'] == self.y) & (self.tempexcel_d['Method'] == self.mms)
                #self.tempexcel = self.tempexcel_d.loc[mask]
                
            
                #get GPU ID and GPU Description list & delete the duplicate(by using group by)
                self.GPU = pd.read_sql("SELECT GPU_ID, GPU_NAME FROM drugs where BUDGET_YEAR = "+str(self.y)+" AND REAL_METHOD_NAME = '"+str(self.mms)+"' GROUP BY GPU_ID, GPU_NAME, BUDGET_YEAR, REAL_METHOD_NAME", self.conn)
                if self.GPU.empty == False:
                    #set index to be GPU ID
                    self.GPU_list = self.GPU.set_index('GPU_ID')
                    
                    #init
                    self.eachGPU = dict()
                    self.maxAmount = dict()
                    self.maxUnitPrice = dict()
                    self.minUnitPrice = dict()
                    #find max & min value of each GPU
                    for index, row in self.GPU_list.iterrows():
                        self.queryMaxAmount(index, self.y, self.mms)
                        self.maxAmount[index] = self.round_half_up(self.resultMaxAmount, 8)
                        
                        self.queryMaxUnitPrice(index, self.y, self.mms)
                        self.maxUnitPrice[index] = self.round_half_up(self.resultMaxUnitPrice, 8)
                        
                        self.queryMinUnitPrice(index, self.y, self.mms)
                        self.minUnitPrice[index] = self.round_half_up(self.resultMinUnitPrice, 8)
                    
                    #get DEPT_ID and DEPT_NAME list & delete the duplicate(by using group by)
                    self.DEPT = pd.read_sql("SELECT DEPT_ID, DEPT_NAME FROM drugs where BUDGET_YEAR = " + str(self.y) + " AND REAL_METHOD_NAME =  '"+str(self.mms)+"' GROUP BY DEPT_ID, DEPT_NAME, BUDGET_YEAR", self.conn)
                    #set index to be DEPT_ID
                    self.DEPT_list = self.DEPT.copy()
                    
                    #create result table
                    self.PAC = pd.DataFrame({'BUDGET_YEAR' : [], 'GPU_ID': [], 'GPU_NAME': [], 'Method' : [], 'DEPT_ID': [], 'DEPT_NAME': [], 'ServicePlanType': [], 'PROVINCE_NAME': [], 'PROVINCE_EN': [], 'Pcode': [], 'Region': [], 'IP': [], 'OP': [], 'Total_Amount': [], 'wavg_unit_price': [], 'Total_Spend': [], 'PAC_value': []})
                    self.PAC_full = pd.DataFrame({'BUDGET_YEAR' : [], 'GPU_ID': [], 'GPU_NAME': [], 'Method' : [], 'DEPT_ID': [], 'DEPT_NAME': [], 'ServicePlanType': [], 'PROVINCE_NAME': [], 'PROVINCE_EN': [], 'Pcode': [], 'Region': [], 'IP': [], 'OP': [], 'Total_Amount': [], 'wavg_unit_price': [], 'Total_Spend': [], 'PAC_value': []})
                    
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
                    
                    self.countTPUelement = pd.DataFrame({'GPU_ID': [], 'GPU_NAME': [], 'Count_TPU': []})
                    for index, row in self.GPU_list.iterrows():
                        tem = []
                        GPU = index
                        sql = "SELECT BUDGET_YEAR, REAL_METHOD_NAME, GPU_ID, GPU_NAME, PROVINCE_NAME, DEPT_ID, DEPT_NAME, SUM(Real_Amount) AS Total_Amount, SUM(Real_Amount * [Real_Unit price]) / SUM(Real_Amount) AS Weighted_Avg_unit_price, SUM(Real_Amount)*(SUM(Real_Amount * [Real_Unit price]) / SUM(Real_Amount)) AS Total_price FROM drugs where BUDGET_YEAR = " + str(self.y) + " AND REAL_METHOD_NAME =  '"+str(self.mms)+"' AND GPU_ID = " + str(GPU) + " GROUP BY BUDGET_YEAR, REAL_METHOD_NAME, DEPT_ID, DEPT_NAME, PROVINCE_NAME, GPU_ID, GPU_NAME ORDER BY Weighted_Avg_unit_price DESC, GPU_ID, DEPT_ID"
                        self.GPUtemp = pd.read_sql(sql, self.conn)
                        hosIdMinPrice_list = []
                        maxPAC = 0
                        #count number of TPU in each GPU
                        sql_count = "SELECT GPU_ID, GPU_NAME, Count(DISTINCT TPU_ID) as Count_TPU FROM drugs where (REAL_METHOD_NAME = '" + str(self.mms) + "') AND (GPU_ID = " + str(GPU) + ") AND (BUDGET_YEAR = " + str(self.y) + ") AND ((GPU_ID IS NOT NULL) OR (GPU_NAME IS NOT NULL)) group by GPU_ID, GPU_NAME, REAL_METHOD_NAME"
                        self.countTPU = pd.read_sql(sql_count, self.conn)
                        
                        for index, row in self.GPUtemp.iterrows():
                            wavg = row['Weighted_Avg_unit_price']
                           
                            mwavg = self.round_half_up(wavg, 8)
                            self.PAC['BUDGET_YEAR'], self.PAC['Method'], self.PAC['GPU_ID'], self.PAC['GPU_NAME'], self.PAC['PROVINCE_NAME'], self.PAC['DEPT_ID'], self.PAC['DEPT_NAME'] = [[row['BUDGET_YEAR']], [row['REAL_METHOD_NAME']], [row['GPU_ID']], [row['GPU_NAME']], row['PROVINCE_NAME'], row['DEPT_ID'], row['DEPT_NAME']]
            
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
                            
                            PACvalue = -(math.log(self.round_half_up(row['Weighted_Avg_unit_price'],8)/self.maxUnitPrice[GPU]))/(self.round_half_up(row['Total_Amount'],8)/self.maxAmount[GPU])
                            PACvalue = self.round_half_up(PACvalue,8)
                            tem.append(PACvalue)
                            
                            #calculate PAC value
                            if mwavg == self.minUnitPrice[GPU]:
                                hosIdMinPrice_list.append(row['DEPT_ID'])
                                
                            self.PAC['PAC_value'] = [PACvalue]
                            self.PAC_full = self.PAC_full.append(self.PAC)
                            
                        self.countTPUelement = self.countTPUelement.append(self.countTPU)
                        maxPAC = max(tem)
                        self.PAC_full.index = range(len(self.PAC_full))
            
                        for y in hosIdMinPrice_list:
                            resultIndex = self.PAC_full.loc[(self.PAC_full['DEPT_ID'] == y) & (self.PAC_full['GPU_ID'] == GPU)].index.values
                            self.PAC_full.loc[resultIndex, 'PAC_value'] = maxPAC
                  
                    self.PAC_full_result = self.PAC_full_result.append(self.PAC_full, ignore_index=True)
        
        #self.countTPUelement = self.countTPUelement.set_index('GPU_ID')
        
    #global round_half_up
    def round_half_up(self, n, decimals=0):
        multiplier = 10**decimals
        return math.floor(n*multiplier + 0.5)/multiplier
      
    #global queryMaxAmount
    def queryMaxAmount(self,GPU, year, m):
        sql = "SELECT TOP (1) SUM(Real_Amount) AS Total_Amount, SUM(Real_Amount * [Real_Unit price]) / SUM(Real_Amount) AS Weighted_Avg_price, SUM(Real_Amount)*(SUM(Real_Amount * [Real_Unit price]) / SUM(Real_Amount)) AS Total_price FROM drugs where BUDGET_YEAR = " + str(year) + " AND GPU_ID = " + str(GPU) + " AND REAL_METHOD_NAME = '" + str(m)+ "' GROUP BY BUDGET_YEAR, DEPT_ID, DEPT_NAME, PROVINCE_NAME, GPU_ID, GPU_NAME ORDER BY Total_Amount DESC"
        #sql = 'SELECT TOP 1 SUM(Real_Amount) AS Total_Amount FROM drugs GROUP BY BUDGET_YEAR, DEPT_ID, DEPT_NAME, PROVINCE_NAME, GPU_ID, GPU_NAME HAVING (BUDGET_YEAR = 2560) AND (GPU_ID = ' + str(GPU) + ') ORDER BY Total_Amount DESC'
        self.resultMaxAmount = pd.read_sql(sql, self.conn).at[0,'Total_Amount']
    
    #global queryMaxUnitPrice
    def queryMaxUnitPrice(self,GPU, year, m):
        sql = "SELECT TOP (1) SUM(Real_Amount) AS Total_Amount, SUM(Real_Amount * [Real_Unit price]) / SUM(Real_Amount) AS Weighted_Avg_price, SUM(Real_Amount)*(SUM(Real_Amount * [Real_Unit price]) / SUM(Real_Amount)) AS Total_price FROM drugs where BUDGET_YEAR = " + str(year) + " AND GPU_ID = " + str(GPU) + " AND REAL_METHOD_NAME = '" + str(m)+ "' GROUP BY BUDGET_YEAR, DEPT_ID, DEPT_NAME, PROVINCE_NAME, GPU_ID, GPU_NAME ORDER BY Weighted_Avg_price DESC"
        self.resultMaxUnitPrice = pd.read_sql(sql, self.conn).at[0,'Weighted_Avg_price']
        
    #global queryMinUnitPrice
    def queryMinUnitPrice(self,GPU, year, m):
        sql = "SELECT TOP (1) SUM(Real_Amount) AS Total_Amount, SUM(Real_Amount * [Real_Unit price]) / SUM(Real_Amount) AS Weighted_Avg_price, SUM(Real_Amount)*(SUM(Real_Amount * [Real_Unit price]) / SUM(Real_Amount)) AS Total_price FROM drugs where BUDGET_YEAR = " + str(year) + " AND GPU_ID = " + str(GPU) + " AND REAL_METHOD_NAME = '" + str(m)+ "' GROUP BY BUDGET_YEAR, DEPT_ID, DEPT_NAME, PROVINCE_NAME, GPU_ID, GPU_NAME ORDER BY Weighted_Avg_price"
        self.resultMinUnitPrice = pd.read_sql(sql, self.conn).at[0,'Weighted_Avg_price']

# function
def dfs_tabs(df_list, sheet_list, file_name):
    writer = pd.ExcelWriter(file_name,engine='xlsxwriter')   
    for dataframe, sheet in zip(df_list, sheet_list):
        dataframe.to_excel(writer, sheet_name=sheet)   
    writer.save()
        
if __name__ == "__main__":
    
    x = dt()
    PAC_full = x.PAC_full_result
    #count = x.countTPUelement
    #count.to_csv('PAC_countTPU_drugs_2562.csv', encoding='utf-8')

    #dfs = [PAC_full]
    #sheets = ['drugs']
    #PAC_full.to_csv('PAC_hos_GPU.csv', encoding='utf-8')
    #dfs_tabs(dfs, sheets, 'PAC_hos_drugs.xlsx')
    PAC_full.to_excel('PAC_hos_GPU.xlsx', sheet_name='drugs', index=False)