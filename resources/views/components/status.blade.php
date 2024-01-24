<div>
    @if($status == 1)
        <a route="{{ route("update-status", $table) }}" onclick="updateStatus(this, `{{ $id }}`)" href="javascript:void(0)">
            <i class="fa fa-toggle-on text-success" style="font-size: 20px" status="1"></i>
        </a>
    @else
        <a route="{{ route("update-status", $table) }}" onclick="updateStatus(this, `{{ $id }}`)" href="javascript:void(0)">
            <i class="fa fa-toggle-off text-danger" style="font-size: 20px" status="0"></i>
        </a>
    @endif
</div>