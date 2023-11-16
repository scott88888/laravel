numTitle
repairNum
selectedValue
serchCon
svgImage
customerNumber
customerName
customerAttn
customerTel
customerAdd
productNum
productName
userID
userName
noticeDate
newPackaging
wire
wipePackaging
rectifier
lens
HDD
other
lensText
HDDText
otherText

'faultSituationCode' => $faultSituation[0],
            'faultSituation' => $faultSituation[1],
            'faultCauseCode' => $faultCause[0],
            'faultCause' => $faultCause[1],
            'faultPart' => $faultPart,
            'faultLocation' => $faultLocation,
            'responsibility' => $responsibility,
            'SN' => $SN,
            'newSN' => $newSN,
            'QADate' => $QADate,
            'completedDate' => $completedDate,
            'userID' => $employeeID,
            'userName' => $employeeName,
            'toll' => $toll,
            'workingHours' => $workingHours,


            
        const faultSituationCodes = $('#faultSituationCodes').val();
        const faultCauseCodes = $('#faultCauseCodes').val();
        const faultPart = $('#faultPart').val();
        const faultLocation = $('#faultLocation').val();
        const responsibility = $('#responsibility').val();
        const SN = $('#SN').val();
        const newSN = $('#newSN').val();
        const QADate = $('#QADate').val();
        const completedDate = $('#completedDate').val();
        const employeeID = $('#employeeID').val();
        const employeeName = $('#employeeName').val();
        const toll = $('#toll').val();
        const workingHours = $('#workingHours').val();