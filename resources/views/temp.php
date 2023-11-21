function getRmaData() {
        var num = '{{$ramData[0]->NUM}}';
        if (num != null && $.trim(num) !== '') {
            var numTitle = num.slice(0, 2); 
            var repairNum = num.slice(2);
        $('#numTitle').val(numTitle);
        $('#repairNum').val(repairNum);
        }else{
            $('#numTitle').val('FA');
        }
        var faultSituationText = '{{$ramData[0]->faultSituationCode.'-'.$ramData[0]->faultSituation }}';
        var faultCauseText = '{{$ramData[0]->faultCauseCode.'-'.$ramData[0]->faultCause }}';        
        $('#responsibility').val('{{$ramData[0]->responsibility }}');
        $('#toll').val('{{$ramData[0]->toll }}');
        $('#newPackaging').prop('checked',  {{$ramData[0]->newPackaging }});
        $('#wire').prop('checked',  {{$ramData[0]->wire }});
        $('#wipePackaging').prop('checked',  {{$ramData[0]->wipePackaging }});
        $('#rectifier').prop('checked',  {{$ramData[0]->rectifier }});
        $('#HDD').prop('checked',  {{$ramData[0]->HDD }});
        $('#lens').prop('checked',  {{$ramData[0]->lens }});
        $('#other').prop('checked',  {{$ramData[0]->other }});
        $('#faultSituationCode').val(faultSituationText).trigger('input');
        $('#faultCauseCode').val(faultCauseText).trigger('input');
       var customRadio = '{{$ramData[0]->repairType }}';
       switch (customRadio) {
        case '維修':
            $('#customRadio1').prop('checked', true);
            break;
            case '借':
            $('#customRadio2').prop('checked', true);
            break;
            case '退':
            $('#customRadio3').prop('checked', true);
            break;
            case '換':
            $('#customRadio4').prop('checked', true);
            break;
            case 'LZ':
            $('#customRadio5').prop('checked', true);
            break;
        default:
        $('#customRadio1').prop('checked', true);
            break;
       }
    };