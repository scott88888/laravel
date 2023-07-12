
var path = window.location.pathname;
var page = path.split('/').pop();
var prefix = page.substring(0, 3);
if (prefix == "mes") {
  $('#documentSearch').last().addClass("active");
  $('#documentSearch a:first-child').attr('aria-expanded', true);
  $('#documentSearch ul').removeClass('collapse').addClass('collapse in').removeAttr('style');

  $('#dashBoard').removeClass('active');
  $('#setup').removeClass('active');
  $('#fileCenter').removeClass('active');
};
if (prefix == "das") {
  $('#dashBoard').last().addClass("active");
  $('#dashBoard a:first-child').attr('aria-expanded', true);
  $('#dashBoard ul').removeClass('collapse').addClass('collapse in').removeAttr('style');

  $('#documentSearch').removeClass('active');
  $('#setup').removeClass('active');
  $('#fileCenter').removeClass('active');
};
if (prefix == "fil") {
  $('#fileCenter').last().addClass("active");
  $('#fileCenter a:first-child').attr('aria-expanded', true);
  $('#fileCenter ul').removeClass('collapse').addClass('collapse in').removeAttr('style');

  $('#documentSearch').removeClass('active');
  $('#dashBoard').removeClass('active');
  $('#setup').removeClass('active');

};
if (prefix == "upd") {
  $('#setup').last().addClass("active");
  $('#setup a:first-child').attr('aria-expanded', true);
  $('#setup ul').removeClass('collapse').addClass('collapse in').removeAttr('style');

  $('#documentSearch').removeClass('active');
  $('#dashBoard').removeClass('active');
  $('#fileCenter').removeClass('active');
};

switch (page) {
  case 'dashboardLeader':
    $('#dashboardLeaderBtn').last().addClass("active");
    break;
  case 'mesRepairProducts':
    $('#mesRepairProductsBtn').last().addClass("active");
    break;
  case 'mesUploadList':
    $('#mesUploadListBtn').last().addClass("active");
    break;
  case 'mesModelList':
    $('#mesModelListBtn').last().addClass("active");
    break;
  case 'mesItemList':
    $('#mesItemListBtn').last().addClass("active");
    break;
  case 'mesItemPartList':
    $('#mesItemPartListBtn').last().addClass("active");
    break;
  case 'mesKickoffList':
    $('#mesKickoffListBtn').last().addClass("active");
    break;
  case 'mesCutsQuery':
    $('#mesCutsQueryBtn').last().addClass("active");
    break;
  case 'mesMonProductionList':
    $('#mesMonProductionListBtn').last().addClass("active");
    break;
  case 'mesProductionResumeList':
    $('#mesProductionResumeListBtn').last().addClass("active");
    break;
  case 'mesHistoryProductionQuantity':
    $('#mesHistoryProductionQuantityBtn').last().addClass("active");
    break;
  case 'mesMfrList':
    $('#mesMfrListBtn').last().addClass("active");
    break;
  case 'mesRunCardList':
    $('#mesRunCardListBtn').last().addClass("active");
    break;
  case 'mesRuncardListNotin':
    $('#mesRuncardListNotinBtn').last().addClass("active");
    break;
  case 'mesDefectiveList':
    $('#mesDefectiveListBtn').last().addClass("active");
    break;
  case 'mesDefectiveRate':
    $('#mesDefectiveRateBtn').last().addClass("active");
    break;
  case 'mesRepairNGList':
    $('#mesRepairNGListBtn').last().addClass("active");
    break;
  case 'mesBuyDelay':
    $('#mesBuyDelayBtn').last().addClass("active");
    break;
  case 'mesECNList':
    $('#mesECNListBtn').last().addClass("active");
    break;
  case 'mesRMAList':
    $('#mesRMAListBtn').last().addClass("active");
    break;
  case 'mesRMAAnalysis':
    $('#mesRMAAnalysisBtn').last().addClass("active");
    break;
  case 'mesShipmentList':
    $('#mesShipmentListBtn').last().addClass("active");
    break;
  case 'fileFirmwareUpload':
    $('#fileFirmwareUploadBtn').last().addClass("active");
    break;
  case 'fileECNEdit':
    $('#fileECNEditBtn').last().addClass("active");
    break;
  case 'update':
    $('#updatePasswordBtn').last().addClass("active");
    break;
  case 'userLoginLog':
    $('#userLoginLogBtn').last().addClass("active");
    break;
  default:
    console.log('Sorry, we are out of ' + page + '.');
}


