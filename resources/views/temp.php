insert into mes_typ_item (`ID`,`TYP_ITEM`,`TYP_CODE`)
value ('','A','3'),('','A0','3'),('','A001','3'),('','A002','3'),('','A003','3'),('','A004','3'),('','A005','3'),('','A006','3'),('','A007','3'),('','A008','3'),('','A011','3'),('','A012','3'),('','A013','3'),('','A014','3'),('','A015','3'),('','A016','3'),('','A017','3'),('','A018','3'),('','A020','3'),('','A1','3'),('','A101','3'),('','A102','3'),('','A103','3'),('','A104','3'),('','A105','3'),('','A106','3'),('','A107','3'),('','A108','5'),('','A109','3'),('','A110','5'),('','A2','2'),('','A201','2'),('','A202','2'),('','A203','2'),('','A204','2'),('','A205','2'),('','B','2'),('','B0','2'),('','B001','2'),('','B002','2'),('','B003','2'),('','B004','2'),('','B1','4'),('','B101','4'),('','B102','4'),('','B103','4'),('','B104','4'),('','B2','4'),('','B201','4'),('','B202','4'),('','B3','1'),('','B301','1'),('','B302','1'),('','B303','1'),('','B304','1'),('','B305','5'),('','B401','1'),('','C0','6'),('','C001','6'),('','C002','6'),('','C003','6'),('','C004','6'),('','C005','6'),('','C006','6'),('','C1','6'),('','C101','6'),('','C102','6'),('','C103','6'),('','D','6'),('','D001','6'),('','D002','1'),('','D003','6'),('','D004','6'),('','D005','6'),('','D006','6'),('','D007','6'),('','D008','6'),('','D009','6'),('','D010','6'),('','D011','2'),('','ZZ','6')




num_ps
nam_items
cod_item
dat_begs
dat_bega
data_gap
qty_pcs
dat_ends
sts_pcs
remark
remark2
num_po
Product
sts_line
PS6
PS5




command.Parameters.AddWithValue("@num_ps",num_ps.ToString());
command.Parameters.AddWithValue("@nam_items",nam_items.ToString());
command.Parameters.AddWithValue("@cod_item",cod_item.ToString());
command.Parameters.AddWithValue("@dat_begs",dat_begs.ToString());
command.Parameters.AddWithValue("@dat_bega",dat_bega.ToString());
command.Parameters.AddWithValue("@data_gap",data_gap.ToString());
command.Parameters.AddWithValue("@qty_pcs",qty_pcs.ToString());
command.Parameters.AddWithValue("@dat_ends",dat_ends.ToString());
command.Parameters.AddWithValue("@sts_pcs",sts_pcs.ToString());
command.Parameters.AddWithValue("@remark",remark.ToString());
command.Parameters.AddWithValue("@remark2",remark2.ToString());
command.Parameters.AddWithValue("@num_po",num_po.ToString());
command.Parameters.AddWithValue("@Product",Product.ToString());
command.Parameters.AddWithValue("@sts_line",sts_line.ToString());
command.Parameters.AddWithValue("@PS6",PS6.ToString());
command.Parameters.AddWithValue("@PS5",PS5.ToString());

command.Parameters.AddWithValue("@NUM_PS", NUM_PS.ToString());



num_ps = oracleReader["NUM_PS"
nam_items = oracleReader["NAM_ITEMS"
cod_item = oracleReader["COD_ITEM"
dat_begs = oracleReader["DAT_BEGS"
dat_bega = oracleReader["DAT_BEGA"
data_gap = oracleReader["DATA_GAP"
qty_pcs = oracleReader["QTY_PCS"
dat_ends = oracleReader["DAT_ENDS"
sts_pcs = oracleReader["STS_PCS"
remark = oracleReader["REMARK"
remark2 = oracleReader["REMARK2"
num_po = oracleReader["NUM_PO"
Product = oracleReader["PRODUCT"
sts_line = oracleReader["STS_LINE"
PS6 = oracleReader["PS6"
PS5 = oracleReader["PS5"

NUM_PS
NAM_ITEMS
COD_ITEM
DAT_BEGS
DAT_BEGA
DATA_GAP
QTY_PCS
DAT_ENDS
STS_PCS
REMARK
REMARK2
NUM_PO
PRODUCT
STS_LINE
PS6
PS5

string num_ps = "";
string nam_items = "";
string cod_item = "";
string dat_begs = "";
string dat_bega = "";
string data_gap = "";
string qty_pcs = "";
string dat_ends = "";
string sts_pcs = "";
string remark = "";
string remark2 = "";
string num_po = "";
string Product = "";
string sts_line = "";
string PS6 = "";
string PS5 = "";