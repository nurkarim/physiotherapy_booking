
<script>
    function loadModal(url){
        var baseUrl='<?php echo URL::to('/'); ?>';
        $("#body-content").load(baseUrl+"/"+url);
    }

    function loadModalEdit(route, id, action){
        var baseUrl='<?php echo URL::to('/'); ?>';
        $("#body-content").load(baseUrl+"/"+ route +'/'+ id +'/'+ action);
    }
</script>

<div class="modal fade" id="modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close btn-close pull-right" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"></h4>
            </div>
            <div class="modal-body" id="body-content">
                <img src="{{asset('images/loading.gif')}}" alt="Loading" title="Loading" height="50px">

            </div>

        </div>
    </div>
</div>
<script>
    $('#modal').on('shown.bs.modal', function () {

    });
</script>
