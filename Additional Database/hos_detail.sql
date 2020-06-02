CREATE TABLE [Hos_detail](
   [BUDGET_YEAR] [smallint] NOT NULL,
   [DEPT_ID] [float] NULL,
   [DEPT_NAME] [nvarchar](100) NOT NULL,
   [ServicePlanType] [nvarchar](50) NOT NULL,
   [PROVINCE_NAME] [nvarchar](50) NOT NULL,
   [PROVINCE_EN] [nvarchar](50) NOT NULL,
   [Pcode] [nvarchar](50) NOT NULL,
   [Region] [float] NOT NULL,
   [IP] [float] NULL,
   [OP] [float] NULL,
   [Total_Spend] [float] NOT NULL
) ON [PRIMARY]
INSERT INTO Hos_detail
       SELECT BUDGET_YEAR, DEPT_ID, DEPT_NAME, ServicePlanType, PROVINCE_NAME, PROVINCE_EN, Pcode, Region, IP, OP, sum(Total_Spend) as Total_Spend
       FROM [PAC_hos_GPU]
       group by BUDGET_YEAR, DEPT_ID, DEPT_NAME, ServicePlanType, PROVINCE_NAME, PROVINCE_EN, Pcode, Region, IP, OP
       order by BUDGET_YEAR, DEPT_ID;