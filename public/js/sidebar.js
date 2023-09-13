
const path = window.location.pathname;
const page = path.split('/').pop();
const url = new URL(window.location.href);
const searchParams = new URLSearchParams(url.search);


const prefix = page.substring(0, 3);
if (prefix == "mes") {
  $('#documentSearch').last().addClass("active");
  $('#documentSearch a:first-child').attr('aria-expanded', true);
  $('#documentSearch ul').removeClass('collapse').addClass('collapse in').removeAttr('style');
  $('#RMA').removeClass('active');
  $('#dashBoard').removeClass('active');
  $('#setup').removeClass('active');
  $('#fileCenter').removeClass('active');
  $('#inventoryList').removeClass('active');
};

if (prefix == "RMA") {
  $('#RMA').last().addClass("active");
  $('#RMA a:first-child').attr('aria-expanded', true);
  $('#RMA ul').removeClass('collapse').addClass('collapse in').removeAttr('style');
  $('#documentSearch').removeClass('active');
  $('#dashBoard').removeClass('active');
  $('#setup').removeClass('active');
  $('#fileCenter').removeClass('active');
  $('#inventoryList').removeClass('active');
};

if (prefix == "das") {
  $('#dashBoard').last().addClass("active");
  $('#dashBoard a:first-child').attr('aria-expanded', true);
  $('#dashBoard ul').removeClass('collapse').addClass('collapse in').removeAttr('style');
  $('#RMA').removeClass('active');
  $('#documentSearch').removeClass('active');
  $('#setup').removeClass('active');
  $('#fileCenter').removeClass('active');
  $('#inventoryList').removeClass('active');
};
if (prefix == "fil") {
  $('#fileCenter').last().addClass("active");
  $('#fileCenter a:first-child').attr('aria-expanded', true);
  $('#fileCenter ul').removeClass('collapse').addClass('collapse in').removeAttr('style');
  $('#RMA').removeClass('active');
  $('#documentSearch').removeClass('active');
  $('#dashBoard').removeClass('active');
  $('#setup').removeClass('active');
  $('#inventoryList').removeClass('active');

};
if (prefix == "upd" | prefix == "use") {
  $('#setup').last().addClass("active");
  $('#setup a:first-child').attr('aria-expanded', true);
  $('#setup ul').removeClass('collapse').addClass('collapse in').removeAttr('style');
  $('#RMA').removeClass('active');
  $('#documentSearch').removeClass('active');
  $('#dashBoard').removeClass('active');
  $('#fileCenter').removeClass('active');
  $('#inventoryList').removeClass('active');
};

if (prefix == "inv") {
  $('#inventoryList').last().addClass("active");
  $('#inventoryList a:first-child').attr('aria-expanded', true);
  $('#inventoryList ul').removeClass('collapse').addClass('collapse in').removeAttr('style');
  $('#RMA').removeClass('active');
  $('#documentSearch').removeClass('active');
  $('#dashBoard').removeClass('active');
  $('#fileCenter').removeClass('active');
  $('#setup').removeClass('active');
};


switch (page) {
  case 'inventoryListUpload':
    $('#inventoryListUploadBtn').last().addClass("active");
    break;
  case 'inventoryList':
    var country = searchParams.get('country');
    if (country === 'US') {
      $('#inventoryListUS').last().addClass("active");
    } else if (country === 'UK') {
      $('#inventoryListUK').last().addClass("active");
    } else if (country === 'AUS') {
      $('#inventoryListAUS').last().addClass("active");
    } else if (country === 'IT') {
      $('#inventoryListIT').last().addClass("active");
    } else if (country === 'MY') {
      $('#inventoryListMY').last().addClass("active");
    }
    break;
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
  case 'inventoryItemList':
    $('#inventoryItemListBtn').last().addClass("active");
    break;
  case 'inventoryItemPartList':
    $('#inventoryItemPartListBtn').last().addClass("active");
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
  case 'RMAList':
    $('#RMAListBtn').last().addClass("active");
    break;
  case 'RMAAnalysis':
    $('#RMAAnalysisBtn').last().addClass("active");
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
  case 'userCheckPermission':
    $('#userCheckPermissionBtn').last().addClass("active");
    break;
  default:
    console.log('Sorry, we are out of ' + page + '.');

}

$(document).ready(function () {
  function fetchData() {
    $.ajax({
      url: 'sidebarPageAjax',
      method: 'GET',
      success: function (response) {
        hideBtn(response);
        var diffIds = response.diffIds;      
      },
      error: function (xhr, status, error) {
        console.error(error);
      }
    });
  }
  function hideBtn(response) {
    for (const pageName of response) {
      $(`#${pageName.replace('/', '\\/')}Btn`).hide();   
      checkAndHideCategory('dashBoard');
      checkAndHideCategory('documentSearch');
      checkAndHideCategory('RMA');
      checkAndHideCategory('fileCenter');
      checkAndHideCategory('inventoryList');
      checkAndHideCategory('setup');
      if (pageName == 'inventoryList') {
        hideInventoryList();
     
      }
    }
  }
  function hideInventoryList() {    
    $('#inventoryListUS').hide();
    $('#inventoryListUK').hide();
    $('#inventoryListAUS').hide();
    $('#inventoryListIT').hide();
    $('#inventoryListMY').hide();
  }

  fetchData();
  function checkAndHideCategory(categoryId) {
    var categoryButtons = $(`#${categoryId} ul li`);
    var allHidden = true;
    categoryButtons.each(function () {
      if ($(this).css('display') !== 'none') {
        allHidden = false;
        return false;
      }
    });
    if (allHidden) {
      $(`#${categoryId}`).hide();
    }
  }


});


