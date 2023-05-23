using System;
using System.IO;
using Oracle.ManagedDataAccess.Client;
using MySql.Data.MySqlClient;
using System.Data;

namespace OracleAndMySqlConnectionExample
{
    class Program
    {
        static void Main(string[] args)
        {
            ProcessData();
            
        }
        private static void ProcessData()
        {
            // 設定 Oracle 連接字串
            string oracleConnString = "Data Source=(DESCRIPTION=(ADDRESS=(PROTOCOL=TCP)(HOST=192.168.0.8)(PORT=1521))(CONNECT_DATA=(SERVICE_NAME=orcl))); User ID=MFDEMO; Password=mf2000;";

            // 設定 MySQL 連接字串
            string mysqlConnString = "Server=192.168.1.104;Database=merit;Uid=admin;Pwd=1234;";

            // 建立 Oracle 連接物件
            OracleConnection oracleConn = new OracleConnection(oracleConnString);

            // 建立 MySQL 連接物件
            MySqlConnection mysqlConn = new MySqlConnection(mysqlConnString);

            try
            {
                // 打開 Oracle 連接
                oracleConn.Open();
                // 創建 OracleCommand 物件，使用 SQL 語句從資料庫中讀取資料
                DateTime today = DateTime.Today; // 取得今天的日期
                DateTime sevenDaysAgo = today.AddDays(-7); // 取得7天前的日期

                string todayString = today.ToString("yyyyMMdd"); // 將今天的日期轉換為字串
                string sevenDaysAgoString = sevenDaysAgo.ToString("yyyyMMdd"); // 將7天前的日期轉換為字串

                string query = $@"SELECT compqm.num_ps, compqm.num_ord, clds.remark2, clds.remark3, clds.dat_begs, clds.dat_bega, clds.cod_item as CLDS_COD_ITEM,
                     clds.QTY_PCS, compqm.num_ps || substr(compqm.seq_comq, 4, 3) num_prod, compqm.seq_comq, compqm.seq_mitem, compqm.cod_mitem,
                     compqm.ps1, compqm.ps2, compqm.ps3, compq.seq_no, compq.cod_item as COMPQ_COD_ITEM, compq.seq_item, clds.ps4, clds.ps5, clds.ps6,
                     '' num_rff, '' num_redo, substr(remark3, 6, 1) line_prod, mseq.dat_del, substr(remark3, 7, 35) prodkey
                     FROM clds, compq, compqm
                     LEFT JOIN (SELECT mseq.cod_item, mseq.no_seq, mseq.dat_del FROM mseq) mseq ON (mseq.no_seq = compqm.seq_mitem)
                     WHERE compqm.num_ps = compqm.num_ps
                     AND (compqm.num_ord = compq.num_ord)
                     AND (compqm.seq_comq = compq.seq_comq)
                     AND (compqm.num_ps = clds.num_ps)
                     AND clds.dat_begs BETWEEN '{sevenDaysAgoString}' AND '{todayString}'
                     ORDER BY clds.dat_begs DESC";
                OracleCommand oracleCmd = new OracleCommand(query, oracleConn);

                // 創建 OracleDataReader 物件
                OracleDataReader oracleReader = oracleCmd.ExecuteReader();
                string message = "mac_query開始執行更新";
                WriteLog(message);
                //Console.WriteLine("開始查詢oracle");
                //判斷是否有資料
                if (oracleReader.HasRows)
                {
                    // 判斷得到的資料3個欄位num_ps &，在mysql中是否能搜尋出來，如果搜尋為0,則新增該筆資料到mysql
                    try
                    {
                        string NUM_PS = "";
                        string NUM_ORD = "";
                        string REMARK2 = "";
                        string REMARK3 = "";
                        string DAT_BEGS = "";
                        string DAT_BEGA = "";
                        string CLDS_COD_ITEM = "";
                        string QTY_PCS = "";
                        string NUM_PROD = "";
                        string SEQ_COMQ = "";
                        string SEQ_MITEM = "";
                        string COD_MITEM = "";
                        string PS1 = "";
                        string PS2 = "";
                        string PS3 = "";
                        string SEQ_NO = "";
                        string SEQ_ITEM = "";
                        string PS4 = "";
                        string PS5 = "";
                        string PS6 = "";
                        string NUM_RFF = "";
                        string NUM_REDO = "";
                        string LINE_PROD = "";
                        string DAT_DEL = "";
                        string PRODKEY = "";
                        string COMPQ_COD_ITEM = "";
                        while (oracleReader.Read())
                        {
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
                            PS4 = oracleReader["PS4"].ToString();
                            PS5 = oracleReader["PS5"].ToString();
                            PS6 = oracleReader["PS6"].ToString();
                            NUM_RFF = oracleReader["NUM_RFF"].ToString();
                            NUM_REDO = oracleReader["NUM_REDO"].ToString();
                            LINE_PROD = oracleReader["LINE_PROD"].ToString();
                            DAT_DEL = oracleReader["DAT_DEL"].ToString();
                            PRODKEY = oracleReader["PRODKEY"].ToString();
                            NUM_PS = oracleReader["NUM_PS"].ToString();
                            SEQ_NO = oracleReader["SEQ_NO"].ToString();
                            COMPQ_COD_ITEM = oracleReader["COMPQ_COD_ITEM"].ToString();
                            SEQ_ITEM = oracleReader["SEQ_ITEM"].ToString();
                            Console.WriteLine("oracle 資料：" + NUM_PS.ToString());
                            Console.WriteLine("oracle 資料：" + SEQ_NO.ToString());
                            Console.WriteLine("oracle 資料：" + SEQ_ITEM.ToString());
                            // 打開 MySQL 連接
                            mysqlConn.Open();

                            // 創建 MySqlCommand 物件，使用 SQL 語句從資料庫中讀取資料
                            MySqlCommand mysqlCmd = new MySqlCommand("SELECT * FROM mac_query WHERE NUM_PS = '" + NUM_PS.ToString() + "' AND SEQ_NO = '" + SEQ_NO.ToString() + "' AND SEQ_ITEM = '" + SEQ_ITEM.ToString() + "'", mysqlConn);

                            // 創建 MySqlDataReader 物件
                            MySqlDataReader mysqlReader = mysqlCmd.ExecuteReader();

                            if (mysqlReader.HasRows)
                            {

                                DataTable dataTable = new DataTable();

                                // 添加列及其数据类型到DataTable，匹配MySqlDataReader中的列
                                for (int i = 0; i < mysqlReader.FieldCount; i++)
                                {
                                    string columnName = mysqlReader.GetName(i);
                                    Type columnType = mysqlReader.GetFieldType(i);
                                    dataTable.Columns.Add(columnName, columnType);
                                }

                                // 加载数据到DataTable
                                dataTable.Load(mysqlReader);

                                // 现在可以使用dataTable对象来访问数据
                                foreach (DataRow row in dataTable.Rows)
                                {
                                    foreach (DataColumn col in dataTable.Columns)
                                    {
                                        string columnName = col.ColumnName;
                                       // Console.WriteLine(columnName);
                                        // Console.WriteLine(row[col]);
                                    }
                                }


                                mysqlReader.Close();

                                foreach (DataRow row in dataTable.Rows)
                                {                                    
                                    try
                                    {
                                       // Console.WriteLine("oracle 資料：" + oracleReader["SEQ_MITEM"].ToString());
                                       // Console.WriteLine("mysql 資料：" + row["SEQ_MITEM"].ToString());
                                        string oracleSEQ_MITEM = oracleReader["SEQ_MITEM"].ToString();
                                        string mysqlSEQ_MITEM = row["SEQ_MITEM"].ToString();
                                        if (!String.IsNullOrEmpty(oracleSEQ_MITEM) && String.IsNullOrEmpty(mysqlSEQ_MITEM))
                                        {
                                            WriteLog("MySql更新資料:NUM_PS" + NUM_PS.ToString());
                                            string updateSql = "UPDATE mac_query SET SEQ_MITEM = '" + oracleSEQ_MITEM + "' WHERE NUM_PS = '" + NUM_PS.ToString() + "' AND SEQ_NO = '" + SEQ_NO.ToString() + "' AND SEQ_ITEM = '" + SEQ_ITEM.ToString() + "'";
                                            MySqlCommand updateCmd = new MySqlCommand(updateSql, mysqlConn);
                                            updateCmd.ExecuteNonQuery();
                                        }
                                    }
                                    catch (MySqlException e)
                                    {
                                        WriteLog($"MySql更新資料錯誤：{e.Message}");                                   
                                    }
                                }

                            }
                            else
                            {
                                mysqlReader.Close();

                                try
                                {                                
                                    WriteLog("更新資料");
                                    string insertSql = "INSERT INTO mac_query (NUM_PS,NUM_ORD,REMARK2,REMARK3,DAT_BEGS,DAT_BEGA,CLDS_COD_ITEM,QTY_PCS,NUM_PROD,SEQ_COMQ,SEQ_MITEM,COD_MITEM,PS1,PS2,PS3,SEQ_NO,COMPQ_COD_ITEM,SEQ_ITEM,PS4,PS5,PS6,NUM_RFF,NUM_REDO,LINE_PROD,DAT_DEL,PRODKEY) VALUES ('" + NUM_PS.ToString() + "','" + NUM_ORD.ToString() + "','" + REMARK2.ToString() + "','" + REMARK3.ToString() + "','" + DAT_BEGS.ToString() + "','" + DAT_BEGA.ToString() + "','" + CLDS_COD_ITEM.ToString() + "','" + QTY_PCS.ToString() + "','" + NUM_PROD.ToString() + "','" + SEQ_COMQ.ToString() + "','" + SEQ_MITEM.ToString() + "','" + COD_MITEM.ToString() + "','" + PS1.ToString() + "','" + PS2.ToString() + "','" + PS3.ToString() + "','" + SEQ_NO.ToString() + "','" + COMPQ_COD_ITEM.ToString() + "','" + SEQ_ITEM.ToString() + "','" + PS4.ToString() + "','" + PS5.ToString() + "','" + PS6.ToString() + "','" + NUM_RFF.ToString() + "','" + NUM_REDO.ToString() + "','" + LINE_PROD.ToString() + "','" + DAT_DEL.ToString() + "','" + PRODKEY.ToString() + "')";
                                    MySqlCommand insertCmd = new MySqlCommand(insertSql, mysqlConn);
                                    int rowsAffected = insertCmd.ExecuteNonQuery();
                                    if (rowsAffected > 0)
                                    {
                                        WriteLog("新增資料成功，寫入NUM_PS=" + NUM_PS.ToString());
                                    }
                                    else
                                    {
                                        WriteLog("新增資料失败，沒有寫入數據。");
                                        
                                    }
                                }
                                catch (MySqlException e)
                                {
                                    WriteLog($"MySql 錯誤：{e.Message}");
                                  
                                }

                            }
                            mysqlConn.Close();
                        }


                    }
                    catch (Exception ex)
                    {
                        Console.WriteLine();
                        WriteLog(ex.Message);
                    }

                }
                else
                {                  
                    WriteLog("oracle沒有資料須更新！");
                }


                // 關閉資源
                oracleReader.Close();
                oracleConn.Close();               
                WriteLog("mac_query更新完成");
                // 等待使用者輸入任意鍵後再退出
                //Console.ReadLine();
            }
            catch (Exception ex)
            {               
                WriteLog(ex.Message);
            }
        }

        private static void WriteLog(string message)
        {
            string logFolderPath = "C:\\logs"; // 設定日誌資料夾的路徑
            string logFileName = DateTime.Now.ToString("yyyyMMdd") + ".txt"; // 使用日期作為檔名
            string logFilePath = Path.Combine(logFolderPath, logFileName); // 組合完整的檔案路徑
          

            try
            {
                // 開啟檔案以進行寫入，如果檔案不存在則會自動建立新檔案
                using (StreamWriter writer = new StreamWriter(logFilePath, true))
                {
                    // 寫入日誌訊息到檔案
                    writer.WriteLine(DateTime.Now.ToString() + " - " + message);
                }

                Console.WriteLine("已寫入日誌檔案");
            }
            catch (Exception ex)
            {
                Console.WriteLine("寫入日誌時發生錯誤：" + ex.Message);
            }
        }
    }
}
