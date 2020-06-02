# -*- coding: utf-8 -*-
"""
Created on Wed Apr 15 22:26:58 2020

@author: pamareel
"""

import pandas as pd
import pyodbc
import numpy as np

class dt:
    def __init__(self):
        #connect to PAC DB
        self.conn = pyodbc.connect('Driver={SQL Server};'
                                   'Server=DESKTOP-66A91QG\MSSQLSERVER2019;'
                                   'Database=PAC;'
                                   'Trusted_Connection=yes;')
        self.cursor = self.conn.cursor()
        
        self.year = pd.read_sql('SELECT DISTINCT BUDGET_YEAR FROM drugs where BUDGET_YEAR IS NOT NULL order by BUDGET_YEAR', self.conn)
        self.method_list = pd.read_sql('SELECT DISTINCT REAL_METHOD_NAME FROM drugs', self.conn)

        self.result_result = pd.DataFrame()
        for index, row in self.year.iterrows():
            self.y = row['BUDGET_YEAR']
            for index, row in self.method_list.iterrows():
                self.mms = row['REAL_METHOD_NAME']
                
                #get GPU ID and GPU Description list & delete the duplicate(by using group by)
                self.GPU = pd.read_sql("SELECT GPU_ID, Method FROM PAC_hos_GPU where BUDGET_YEAR = "+str(self.y)+" AND Method = '"+str(self.mms)+"' GROUP BY GPU_ID, Method, BUDGET_YEAR", self.conn)
                if self.GPU.empty == False:
                    self.GPU_list = self.GPU[['GPU_ID', 'Method']].copy()
    
                
                    self.tempexcel = pd.read_sql("SELECT * FROM PAC_hos_GPU where BUDGET_YEAR = "+str(self.y)+" AND Method = '"+str(self.mms)+"'", self.conn)
                    t_excel = self.tempexcel.copy()

        
                    #GPU_NAME with ID and YEAR list
                    self.GPU_NAME = self.tempexcel[['BUDGET_YEAR','GPU_ID','GPU_NAME', 'Method']].copy()
                    #group/delete the duplicate
                    self.result = self.GPU_NAME.drop_duplicates(subset=None, keep='first')
                
                
                    #calculate PAC average and total_amount and Wavg_Unit_Price, TOTAL_SPEND(=total_amount*Wavg_Unit_Price =sum(Total_price))
                    self.PAC = dict()
                    self.tAmount = dict()
                    self.wavgPrice = dict()
                    self.tSpend = dict()
                    self.totalPac = dict()
                    self.totalCount = dict()
                    self.gpmd = pd.DataFrame()
                    #for Gini
                    #self.eachPac = dict()
                    ix = 0
                    for index, row in self.GPU_list.iterrows():
                        a = row['GPU_ID']
                        m = row['Method']
                        totalAmount = 0
                        WavgPrice_up = 0
                        totalSpend = 0
                        totalPac = 0
                        count = 0
                        
                        resultIndex = self.result.loc[(self.result['GPU_ID'] == a) & (self.result['Method'] == m)].index.values
                        for index, row in t_excel.iterrows():
                            
                            GPP = row['GPU_ID']
                            MM = row['Method']
                    
                            if GPP == a :
                                if MM ==m:
                                    totalAmount = totalAmount + row['Total_Amount']
                                    totalSpend = totalSpend + row['Total_Spend']
                                    
                                    Total_Amount = row['Total_Amount']
                                    wavg_unit_price = row['wavg_unit_price']
                                    taa = float(Total_Amount) * float(wavg_unit_price)
                                    WavgPrice_up = WavgPrice_up + taa
                                    
                                    count = count+1
                                    PAC_value = float(row['PAC_value'])
                                    totalPac = totalPac + PAC_value
                        
                        self.tAmount[ix] = totalAmount
                        self.wavgPrice[ix] = WavgPrice_up/totalAmount
                        self.tSpend[ix] = totalSpend
                        self.totalPac[ix] = totalPac
                        
                        self.gpmd_t = pd.DataFrame({"ix":[ix], "a":[a], "m":[m]})
                        self.gpmd = self.gpmd.append(self.gpmd_t, ignore_index=True)
                        
                        self.totalCount[ix] = count
                        self.PAC[ix] = totalPac/count
                        #put all data into same dataframe
                        self.result.loc[resultIndex, 'Total_Amount'] = self.tAmount[ix]
                        self.result.loc[resultIndex, 'wavg_unit_price'] = self.wavgPrice[ix]
                        self.result.loc[resultIndex, 'Total_Spend'] = self.tSpend[ix]
                        self.result.loc[resultIndex, 'Avg_PAC'] = self.PAC[ix]
                        ix = ix+1
                        
                    self.cumPropA = dict.fromkeys(self.gpmd['ix'], 0)
                    self.sumCumPropA = dict.fromkeys(self.gpmd['ix'], 0)
                    self.PropH = dict.fromkeys(self.gpmd['ix'], 0)
                    self.cumPropH = dict.fromkeys(self.gpmd['ix'], 0)
                    self.sumCumPropH = dict.fromkeys(self.gpmd['ix'], 0)
                    self.sumZ = dict.fromkeys(self.gpmd['ix'], 0)
                    #gini calculation
                    for index, row in self.GPU_list.iterrows(): 
                        gid = row['GPU_ID']
                        mname = row['Method']
                        
                        resultIndex = self.gpmd.loc[(self.gpmd['a'] == gid) & (self.gpmd['m'] == mname)].index.values.item()
                        ix = self.gpmd.get_value(resultIndex, 'ix')
        
                        for index, row in t_excel.iterrows(): 
                            if row['GPU_ID'] == gid and row['Method'] == mname:
                                if self.totalPac[ix] != 0:
                                    PAC_value = float(row['PAC_value'])
                                    if PAC_value != 0:
                                        PropA = PAC_value/self.totalPac[ix]
                                    else:
                                        PropA = 0
                                        
                                    oldCumPropA = self.cumPropA[ix]
                                    self.cumPropA[ix] = self.cumPropA[ix] + PropA
                                    
                                    #self.sumCumPropA[gid] = oldCumPropA + self.cumPropA[gid]
                                    self.PropH[ix] = 1/self.totalCount[ix]
                                    oldCumPropH = self.cumPropH[ix]
                                    self.cumPropH[ix] = self.cumPropH[ix] + self.PropH[ix]
        
                                    #self.sumCumPropH[gid] = oldPropH + self.cumPropH[gid]
                                    A = self.cumPropH[ix] - oldCumPropH
                                    B = self.cumPropA[ix] + oldCumPropA
                                    Z = A*B
                                    self.sumZ[ix] = self.sumZ[ix] + Z
                                    
                                else:
                                    self.sumZ[ix] = 0
                        
                            
                    #self.Gini = dict.fromkeys(self.GPU_list, 0)
                    self.Gini = dict()
                    for index, row in self.GPU_list.iterrows():
                        gid = row['GPU_ID']
                        m = row['Method']
                        
                        resultIndex = self.gpmd.loc[(self.gpmd['a'] == gid) & (self.gpmd['m'] == m)].index.values.item()
                        b = self.gpmd.get_value(resultIndex, 'ix')
                        
                        if self.sumZ[b] != 0:
                            self.Gini[b] = abs(1-self.sumZ[b])
                        else:
                            self.Gini[b] = None
                        #put Gini into same dataframe
                        resultIndex = self.result.loc[(self.result['GPU_ID'] == gid) & (self.result['Method'] == m)].index.values
                        gi = self.Gini[b]
                        self.result.loc[resultIndex, 'Gini'] = gi
                        
                    self.result_result = self.result_result.append(self.result, ignore_index=True)
# function
def dfs_tabs(df_list, sheet_list, file_name):
    writer = pd.ExcelWriter(file_name,engine='xlsxwriter')   
    for dataframe, sheet in zip(df_list, sheet_list):
        dataframe.to_excel(writer, sheet_name=sheet)   
    writer.save()         

if __name__ == "__main__":
    
    x = dt()
    #put result dataframe into excel
    resultAll = x.result_result
    
    #dfs = [resultAll]
    #sheets = ['AllInfospecific2560']
    resultAll.to_excel('Gini_drugs_GPU.xlsx', sheet_name='drugs', index=False)
    #.to_csv('Gini_drugs_GPU.csv', encoding = 'utf-8')
    #dfs_tabs(dfs, sheets, )