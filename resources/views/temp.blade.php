
<div class="container">
    <h1>網路資料夾檔案列表</h1>
    <ul>
        @isset($files)
            @foreach ($files as $file)
                <a href="{{ asset('storage/mesItemPartList/' . basename($file)) }}" target="_blank">{{ basename($file) }}</a><br>
            @endforeach
        @else
            <p>沒有可顯示的檔案。</p>
        @endisset
    </ul>
</div>

