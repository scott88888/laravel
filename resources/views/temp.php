<tr>
                                                <td class="hide_column">{{$ListData->fw_id}}</td>
                                                <td>{{$ListData->customer}}</td>
                                                <td>{{$ListData->model_no}}</td>
                                                <td>{{$ListData->model_customer}}</td>
                                                <td>{{$ListData->product_type}}</td>
                                                <td>{{$ListData->model_name}}</td>
                                                <td>{{$ListData->customer_oem}}</td>
                                                <td>{{$ListData->version}}</td>
                                                <td>
                                                    @if ($ListData->file_kernel_url != null)
                                                    <div>
                                                        <a href="http://mes.meritlilin.com.tw/support/www/MES/lilin/{{$ListData->file_kernel_url}}" target="_blank">
                                                            <img src="{{ asset('images/icon/Backup_Blue_64x64px.png')}}" style="width: 1.5rem;" alt="{{$ListData->file_kernel_url}}">
                                                    </div>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($ListData->file_app_url != null)
                                                    <div>
                                                        <a href="http://mes.meritlilin.com.tw/support/www/MES/lilin/{{$ListData->file_app_url}}" target="_blank">
                                                            <img src="{{ asset('images/icon/Backup_Blue_64x64px.png')}}" style="width: 1.5rem;" alt="{{$ListData->file_app_url}}">
                                                    </div>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($ListData->file_note_pdf_url != null)
                                                    <div>
                                                        <a href="http://mes.meritlilin.com.tw/support/www/MES/lilin/{{$ListData->file_note_pdf_url}}" target="_blank">
                                                            <img src="{{ asset('images/icon/pdf_download.png')}}" style="width: 1.5rem;" alt="{{$ListData->file_note_pdf_url}}">
                                                    </div>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($ListData->ow_url != null)
                                                    <div>
                                                        <a href="http://mes.meritlilin.com.tw/support/www/MES/lilin/{{$ListData->ow_url}}" target="_blank">
                                                            <img src="{{ asset('images/icon/zip_ow.png')}}" style="width: 1.5rem;" alt="{{$ListData->ow_url}}">
                                                    </div>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($ListData->file_report_url != null)
                                                    <div>
                                                        <a href="http://mes.meritlilin.com.tw/support/www/MES/lilin/{{$ListData->file_report_url}}" target="_blank">
                                                            <img src="{{ asset('images/icon/QA_report.png')}}" style="width: 1.5rem;" alt="{{$ListData->file_report_url}}">
                                                    </div>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($ListData->file_other_url != null)
                                                    <div>
                                                        <a href="http://mes.meritlilin.com.tw/support/www/MES/lilin/{{$ListData->file_other_url}}" target="_blank">
                                                            <img src="{{ asset('images/icon/zip.png')}}" style="width: 1.5rem;" alt="{{$ListData->file_other_url}}">
                                                    </div>
                                                    @endif
                                                </td>
                                                <td>{{$ListData->pantilt_ver}}</td>
                                                <td>{{$ListData->lens_ver}}</td>
                                                <td>{{$ListData->lens_parameter}}</td>
                                                <td>{{$ListData->p_ver}}</td>
                                                <td>{{$ListData->recovery_ver}}</td>
                                                <td>{{$ListData->ai_ver}}</td>
                                                <td>{{$ListData->upload_date}}</td>
                                                <td>{{$ListData->upload_man}}</td>
                                                <td>
                                                    @if ($ListData->Remark != null)
                                                    <div>
                                                        <a href="{{$ListData->Remark}}" target="_blank">
                                                            <i class='ti-link'></i>
                                                    </div>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($ListData->upload_date2 != '0000-00-00 00:00:00')
                                                    <div>
                                                        {{$ListData->upload_date2}}
                                                    </div>
                                                    @endif
                                                </td>
                                            </tr>