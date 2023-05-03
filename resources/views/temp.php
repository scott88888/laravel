              
SELECT 
    c.COD_ITEM, 
    c.TOTAL, 
    c.A, 
    c.B, 
    i.NAM_ITEM, 
    m.minDELtime, 
    m.maxDELtime
FROM (
    SELECT 
        CLDS.COD_ITEM, 
        SUM(CLDS.QTY_PCS) AS TOTAL, 
        MAX(CLDS.DAT_BEGA) AS MAX_CLDS_DAT_BEGA, 
        MIN(CLDS.DAT_BEGA) AS MIN_CLDS_DAT_BEGA, 
    FROM CLDS
    WHERE CLDS.COD_ITEM like 'UFG%'
    or CLDS.COD_ITEM like 'XHG%'
    or CLDS.COD_ITEM like 'ZFR%'
    or CLDS.COD_ITEM like 'UHG%'
    or CLDS.COD_ITEM like 'ZHR%'
    or CLDS.COD_ITEM like 'SG%'
    or CLDS.COD_ITEM like 'SR%'
    or CLDS.COD_ITEM like 'ZR%'
    or CLDS.COD_ITEM like 'ZSR%'
    or CLDS.COD_ITEM like 'Z2R%'
    or CLDS.COD_ITEM like 'P2R%'
    or CLDS.COD_ITEM like 'P2G%'
    or CLDS.COD_ITEM like 'MR%'
    or CLDS.COD_ITEM like 'MG%'
    or CLDS.COD_ITEM like 'MD%'
    or CLDS.COD_ITEM like 'ZMR%'
    or CLDS.COD_ITEM like 'IPR%'
    or CLDS.COD_ITEM like 'IPD%'
    or CLDS.COD_ITEM like 'IPG%'
    or CLDS.COD_ITEM like 'ZG%'
    or CLDS.COD_ITEM like 'LB%'
    or CLDS.COD_ITEM like 'LD%'
    or CLDS.COD_ITEM like 'LR%'
    or CLDS.COD_ITEM like 'FR%'
    or CLDS.COD_ITEM like 'IPC%'
    or CLDS.COD_ITEM like 'DB%'
    or CLDS.COD_ITEM like 'PSR%'
    or CLDS.COD_ITEM like 'IPS%'
    or CLDS.COD_ITEM like 'Z5R%'
    or CLDS.COD_ITEM like 'P5R%'
    or CLDS.COD_ITEM like 'P5G%'
    or CLDS.COD_ITEM like 'Z3R%'
    or CLDS.COD_ITEM like 'P3R%'
    or CLDS.COD_ITEM like 'P3G%'
    or CLDS.COD_ITEM like 'PZD%'
    or CLDS.COD_ITEM like 'VK%'
    or CLDS.COD_ITEM like 'VN%'
    or CLDS.COD_ITEM like 'AiP%'
    or CLDS.COD_ITEM like 'CAM%'
    or CLDS.COD_ITEM like 'CB%'
    or CLDS.COD_ITEM like 'CC-%'
    or CLDS.COD_ITEM like 'CG%'
    or CLDS.COD_ITEM like 'CK%'
    or CLDS.COD_ITEM like 'CM%'
    or CLDS.COD_ITEM like 'DHD%'
    or CLDS.COD_ITEM like 'DVR%'
    or CLDS.COD_ITEM like 'ED%'
    or CLDS.COD_ITEM like 'EL%'
    or CLDS.COD_ITEM like 'ER%'
    or CLDS.COD_ITEM like 'ES%'
    or CLDS.COD_ITEM like 'EVR%'
    or CLDS.COD_ITEM like 'EZ%'
    or CLDS.COD_ITEM like 'F2R%'
    or CLDS.COD_ITEM like 'FD%'
    or CLDS.COD_ITEM like 'FR%'
    or CLDS.COD_ITEM like 'HL%'
    or CLDS.COD_ITEM like 'IRS%'
    or CLDS.COD_ITEM like 'NVR%'
    or CLDS.COD_ITEM like 'PIH%'
    or CLDS.COD_ITEM like 'AH%'
    or CLDS.COD_ITEM like 'NAV%'
    or CLDS.COD_ITEM like 'PS%'
    or CLDS.COD_ITEM like 'NCS%'                         
    or CLDS.COD_ITEM like 'AR2015E%'
    or CLDS.COD_ITEM like 'ARR2010E%'
    or CLDS.COD_ITEM like 'DB052E%'
    or CLDS.COD_ITEM like 'AC1082%'
    or CLDS.COD_ITEM like 'ACW1012%'
    or CLDS.COD_ITEM like 'ARM5%'
    or CLDS.COD_ITEM like 'PMH-PSU330%'    
    or CLDS.COD_ITEM like 'UHR%'
    or CLDS.COD_ITEM like 'OM%'
    or CLDS.COD_ITEM like 'PSW%'
    or CLDS.COD_ITEM like 'AE-%'
    or CLDS.COD_ITEM like 'P4%'
    or CLDS.COD_ITEM like 'YK-%'
    or CLDS.COD_ITEM like 'YC-%'
    or CLDS.COD_ITEM like 'SV-%'
    or CLDS.COD_ITEM like 'S7R%'
    or CLDS.COD_ITEM like 'Z7R%'
    or CLDS.COD_ITEM like 'P4R%'
    or CLDS.COD_ITEM like '36-%'
    or CLDS.COD_ITEM like 'S8R%'
    or CLDS.COD_ITEM like 'E5R%'
    or CLDS.COD_ITEM like '010-%'
    or CLDS.COD_ITEM like 'DS-%'
    or CLDS.COD_ITEM like 'BT%'
    or CLDS.COD_ITEM like 'PRH%'
    or CLDS.COD_ITEM like 'SD%'
    or CLDS.COD_ITEM like 'KYW%'
    or CLDS.COD_ITEM like 'NTS%'
    or CLDS.COD_ITEM like 'P3C%'
    or CLDS.COD_ITEM like 'BCR%'
    or CLDS.COD_ITEM like 'P6R%'
    or CLDS.COD_ITEM like 'VD022%'
    or CLDS.COD_ITEM like 'Z6R%'
    or CLDS.COD_ITEM like 'AH55%'
    or CLDS.COD_ITEM like 'TV-%' 
    GROUP BY CLDS.COD_ITEM
) c
LEFT JOIN ITEM i ON c.COD_ITEM = i.COD_ITEM
LEFT JOIN (
    SELECT 
        COD_ITEM, 
        MIN(DAT_DEL) AS minDELtime, 
        MAX(DAT_DEL) AS maxDELtime
    FROM MSEQ
    GROUP BY COD_ITEM
) m ON c.COD_ITEM = m.COD_ITEM;