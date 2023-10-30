NUM_BROW
COD_DPT
NAM_EMP
EMP_BROW
EMP_LST
NAM_CUSTS
COD_CUST
COD_ITEM
DAT_BROW
DAT_RRTN
DAT_ARTN
STS_BROW
QTY_BROW
CNT_ARTN
CLS_BROW



command.Parameters.AddWithValue("@NUM_BROW", NUM_BROW.ToString());
command.Parameters.AddWithValue("@COD_DPT", COD_DPT.ToString());
command.Parameters.AddWithValue("@NAM_EMP", NAM_EMP.ToString());
command.Parameters.AddWithValue("@EMP_BROW", EMP_BROW.ToString());
command.Parameters.AddWithValue("@EMP_LST", EMP_LST.ToString());
command.Parameters.AddWithValue("@NAM_CUSTS", NAM_CUSTS.ToString());
command.Parameters.AddWithValue("@COD_CUST", COD_CUST.ToString());
command.Parameters.AddWithValue("@COD_ITEM", COD_ITEM.ToString());
command.Parameters.AddWithValue("@DAT_BROW", DAT_BROW.ToString());
command.Parameters.AddWithValue("@DAT_RRTN", DAT_RRTN.ToString());
command.Parameters.AddWithValue("@DAT_ARTN", DAT_ARTN.ToString());
command.Parameters.AddWithValue("@STS_BROW", STS_BROW.ToString());
command.Parameters.AddWithValue("@QTY_BROW", QTY_BROW.ToString());
command.Parameters.AddWithValue("@CNT_ARTN", CNT_ARTN.ToString());
command.Parameters.AddWithValue("@CLS_BROW", CLS_BROW.ToString());






NUM_BROW = oracleReader["NUM_BROW"].ToString();
COD_DPT = oracleReader["COD_DPT"].ToString();
NAM_EMP = oracleReader["NAM_EMP"].ToString();
EMP_BROW = oracleReader["EMP_BROW"].ToString();
EMP_LST = oracleReader["EMP_LST"].ToString();
NAM_CUSTS = oracleReader["NAM_CUSTS"].ToString();
COD_CUST = oracleReader["COD_CUST"].ToString();
COD_ITEM = oracleReader["COD_ITEM"].ToString();
DAT_BROW = oracleReader["DAT_BROW"].ToString();
DAT_RRTN = oracleReader["DAT_RRTN"].ToString();
DAT_ARTN = oracleReader["DAT_ARTN"].ToString();
STS_BROW = oracleReader["STS_BROW"].ToString();
QTY_BROW = oracleReader["QTY_BROW"].ToString();
CNT_ARTN = oracleReader["CNT_ARTN"].ToString();
CLS_BROW = oracleReader["CLS_BROW"].ToString();