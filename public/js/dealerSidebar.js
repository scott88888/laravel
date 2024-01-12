
const path = window.location.pathname;
const url = new URL(window.location.href);
const searchParams = new URLSearchParams(url.search);
const page = path.split('/').pop();
const prefix = page.substring(0, 3);

if (page == "dealerMSDS") {
  setActive('#supplierMmanagement');
 
}


function setActive(elementId) {
  $(elementId).last().addClass("active");
  $(elementId + ' a:first-child').attr('aria-expanded', true);
  $(elementId + ' ul').removeClass('collapse').addClass('collapse in').removeAttr('style');
}

function removeActive(elements) {
  elements.forEach(function (element) {
    $(element).removeClass('active');
  });
}

switch (page) {
  case 'dealerMSDS':
    $('#dealerMSDSBtn').last().addClass("active");
    break;
    case 'dealerMSDS#':
    $('#dealerMSDSBtn').last().addClass("active");
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
      checkAndHideCategory('mesMSDS');
      
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


