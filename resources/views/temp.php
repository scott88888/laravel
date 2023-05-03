'{NUM_PS}',
'{NUM_ORD}','{REMARK2}','{REMARK3}','{DAT_BEGS}','{DAT_BEGA}','{CLDS_COD_ITEM}','{QTY_PCS}','{NUM_PROD}','{SEQ_COMQ}','{SEQ_MITEM}','{COD_MITEM}','{PS1}','{PS2}','{PS3}','{SEQ_NO}','{COMPQ_COD_ITEM}','{SEQ_ITEM}','{PS4}','{PS5}','{PS6}','{NUM_RFF}','{NUM_REDO}','{LINE_PROD}','{DAT_DEL}','{PRODKEY}'



NUM_PS = oracleReader["num_ps"].ToString();

NUM_PS = oracleReader["NUM_PS"].ToString();
NUM_ORD = oracleReader["NUM_ORD"].ToString();
REMARK2 = oracleReader["REMARK2"].ToString();
REMARK3 = oracleReader["REMARK3"].ToString();
DAT_BEGS = oracleReader["DAT_BEGS"].ToString();
DAT_BEGA = oracleReader["DAT_BEGA"].ToString();
CLDS_COD_ITEM = oracleReader["CLDS_COD_ITEM"].ToString();
QTY_PCS = oracleReader["QTY_PCS"].ToString();
NUM_PROD = oracleReader["NUM_PROD"].ToString();
SEQ_COMQ = oracleReader["SEQ_COMQ"].ToString();
SEQ_MITEM = oracleReader["SEQ_MITEM"].ToString();
COD_MITEM = oracleReader["COD_MITEM"].ToString();
PS1 = oracleReader["PS1"].ToString();
PS2 = oracleReader["PS2"].ToString();
PS3 = oracleReader["PS3"].ToString();
SEQ_NO = oracleReader["SEQ_NO"].ToString();
COMPQ_COD_ITEM = oracleReader["COMPQ_COD_ITEM"].ToString();
SEQ_ITEM = oracleReader["SEQ_ITEM"].ToString();
PS4 = oracleReader["PS4"].ToString();
PS5 = oracleReader["PS5"].ToString();
PS6 = oracleReader["PS6"].ToString();
NUM_RFF = oracleReader["NUM_RFF"].ToString();
NUM_REDO = oracleReader["NUM_REDO"].ToString();
LINE_PROD = oracleReader["LINE_PROD"].ToString();
DAT_DEL = oracleReader["DAT_DEL"].ToString();
PRODKEY = oracleReader["PRODKEY"].ToString();



string insertSql = $"INSERT INTO MAC_QUERY (NUM_PS,NUM_ORD,REMARK2,REMARK3,DAT_BEGS,DAT_BEGA,CLDS_COD_ITEM,QTY_PCS,NUM_PROD,SEQ_COMQ,SEQ_MITEM,COD_MITEM,PS1,PS2,PS3,SEQ_NO,COMPQ_COD_ITEM,SEQ_ITEM,PS4,PS5,PS6,NUM_RFF,NUM_REDO,LINE_PROD,DAT_DEL,PRODKEY) VALUES ('{NUM_PS}','{NUM_ORD}','{REMARK2}','{REMARK3}','{DAT_BEGS}','{DAT_BEGA}','{CLDS_COD_ITEM}','{QTY_PCS}','{NUM_PROD}','{SEQ_COMQ}','{SEQ_MITEM}','{COD_MITEM}','{PS1}','{PS2}','{PS3}','{SEQ_NO}','{COMPQ_COD_ITEM}','{SEQ_ITEM}','{PS4}','{PS5}','{PS6}','{NUM_RFF}','{NUM_REDO}','{LINE_PROD}','{DAT_DEL}','{PRODKEY}')";



INSERT INTO MAC_QUERY (NUM_PS,
NUM_ORD,
REMARK2,
REMARK3,
DAT_BEGS,
DAT_BEGA,
CLDS_COD_ITEM,
QTY_PCS,
NUM_PROD,
SEQ_COMQ,
SEQ_MITEM,
COD_MITEM,
PS1,
PS2,
PS3,
SEQ_NO,
COMPQ_COD_ITEM,
SEQ_ITEM,
PS4,
PS5,
PS6,
NUM_RFF,
NUM_REDO,
LINE_PROD,
DAT_DEL,
PRODKEY) VALUES 
('AA230412003'
,'AA230412003'
,'重工/美國參展'
,'0801'
'20230412'
''
'S8D4654EX30'
'2'
'AA230412003001'
'000001'
'2210004739'
'S8D4654EX30'
'AA2304120030001'
''
'N'
'001'
'S8D4654EX30'
'2210004739'
''
'CAM:3.23IP 12.1.001.4120\r\n'
''
''
''
''
''
'')


SELECT 
        cod_item,nam_item,dsc_allc,dsc_alle,cod_loc,qty_stk,ser_pcs, eol_list.official_website2 
        FROM `lcst` 
      
        where cod_item not REGEXP '^[0-9]' and cod_loc ='GO-001' or cod_loc ='WO-003' or cod_loc ='LL-000'


        SELECT 
        cod_item,nam_item,dsc_allc,cod_loc,qty_stk,
        FROM `lcst`       
        where cod_loc ='AO-111' or cod_loc ='  GO-001' or cod_loc ='GO-003' or cod_loc ='LL-000' or cod_loc ='WO-003'


        AO-111
        GO-001
        GO-003
        LL-000
        WO-003


        SELECT * 
        FROM lcst_temp
WHERE (cod_loc ='AO-111' or cod_loc ='  GO-001' or cod_loc ='GO-003' or cod_loc ='LL-000' or cod_loc ='WO-003') AND qty_stk > 0



SELECT  
lcst.cod_item,
lcst.cid_loc,
lcst.unt_stk,
lcst.qty_stk,
item.cod_item,
item.nam_item,
item.dsc_item
from lcst
left join item on lcst.cod_item = item.cod_item,
where lcst.cod_item not REGEXP '^[0-9]' and lcst.cod_loc ='GO-001' or lcst.cod_loc ='WO-003' or lcst.cod_loc ='LL-000'


調整 mes_lcst_item 為成品  不含 cod_loc ='AO-111'
調整 mes_lcst_XXX 為料件 cod_loc ='AO-111'



class MesModelList extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
public static function getItemListData1()
    {
        
        // $value = DB::select("SELECT * FROM lcst");
        $value = MesModelList::orderBy('qty_stk', 'asc')->get();
        return $value;
    }
    public static function getItemListData2()
    {
        
        // $value = DB::select("SELECT * FROM lcst");
        $value = MesModelList::orderBy('qty_stk', 'asc')->get();
        return $value;
    }
}


SELECT POLN.QTY_REQ ,           POLN.NUM_LINE ,           POLN.STS_LINE ,           POLN.COD_ITEMO ,           POLN.TYP_POLN ,           POLN.DAT_DELS ,           POLN.COD_ITEM ,           POLN.NUM_SALM,           POLN.LIN_SALG,           ITEM.CLS_PROD ,           ITEM.NAM_ITEM,           POHD.COD_CUST ,           POHD.NUM_PO ,           POHD.DAT_RFF ,           POHD.COD_EMPIN ,           POHD.COD_EMPSL ,           POHD.NUM_RFF ,           POHD.COD_DPT ,           POLN.QTY_DEL ,           POHD.DAT_KEYIN ,           POHD.DAT_TRN ,           POLN.MNY_UNIT ,           POHD.NUM_CNTL ,           POHD.POS_DEL ,           POLN.MNY_AMT ,           POLN.QTY_ATTN ,           POHD.REMARK ,           POLN.NUM_CASE ,           ITEM.NAM_ITEM ,           CUST.NAM_CUSTS ,           POHD.DAT_PO ,           POHD.COD_CONF ,           POHD.DAT_CONF ,           POHD.TIM_CONF ,           POHD.TYP_POHD,           POLN.QTY_REQD ,           POLN.QTY_CLDS ,           POLN.DAT_REQD ,           POLN.TYP_CLOSE,           POLN.PS1,           POLN.PS2,           POLN.EMP_REQD,           POHD.COD_DOLA,           POLN.COD_ANS,           POLN.COD_SIT,           POLN.CLS_ARMM,           POHD.NUM_RFF,           pohd.emp_trn,           poln.cod_unit,           pohd.tax_type,           pohd.rff_rate,           pohd.num_qut,           pohd.ser_qut,           poln.num_cstm,           poln.lin_cstm,           '' unit1,           0 qty1,           0 mny_unit1,           '' unit2,           0 qty2,           0 mny_unit2,           '' unit3,           0 qty3,           0 mny_unit3      FROM ITEM,           POLN,           POHD,           CUST     WHERE ( POHD.COD_CUST  = POLN.COD_CUST  ) and           ( POHD.NUM_PO  = POLN.NUM_PO  ) and           ( ITEM.COD_ITEM  = POLN.COD_ITEM  ) and           ( POHD.COD_CUST  = CUST.COD_CUST  )   



select 
POPS.NUM_PS,
ITEM.NAM_ITEM,
POPS.COD_ITEM,
CLDS.DAT_BEGS,
CLDS.DAT_BEGA,
(TO_DATE(CLDS.DAT_BEGA, 'YYYYMMDD') - TO_DATE(CLDS.DAT_BEGS, 'YYYYMMDD')) AS DATA_GAP,
CLDS.QTY_PCS,
CLDS.STS_PCS,
POPS.NUM_PO,
POLN.STS_LINE,
FROM CLDS
LEFT JOIN 
POPS.NUM_PS = CLDS.NUM_PS
ITEM.COD_ITEM  = POP.COD_ITEM
POPS.NUM_PO  = POLN.NUM_PO & ITEM.COD_ITEM  = POLN.COD_ITEM 

SELECT 
    POPS.NUM_PS,    
    ITEM.NAM_ITEM AS NAM_ITEMS,
    POPS.COD_ITEM,
    CLDS.DAT_BEGS,
    CLDS.DAT_BEGA,
    (TO_DATE(CLDS.DAT_BEGA, 'YYYYMMDD') - TO_DATE(CLDS.DAT_BEGS, 'YYYYMMDD')) AS DATA_GAP,
    CLDS.QTY_PCS,
    CLDS.DAT_ENDS,
    CLDS.STS_PCS,
    CLDS.REMARK,
    CLDS.REMARK2,
    POPS.NUM_PO,
    POLN.STS_LINE,
    CLDS.PS6,
    CLDS.PS5
FROM CLDS
LEFT JOIN POPS
    ON CLDS.NUM_PS = POPS.NUM_PS
LEFT JOIN ITEM
ON ITEM.COD_ITEM  = POPS.COD_ITEM
LEFT JOIN POLN
ON POPS.NUM_PO  = POLN.NUM_PO AND ITEM.COD_ITEM  = POLN.COD_ITEM 
WHERE  POPS.NUM_PS IS NOT NULL AND POPS.NUM_PS != '(Null)' AND CLDS.DAT_BEGS > '20220930'
ORDER BY CLDS.DAT_BEGS ASC
