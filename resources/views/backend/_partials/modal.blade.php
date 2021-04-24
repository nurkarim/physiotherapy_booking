
<script>
    function loadModal(url){
        var baseUrl='<?php echo URL::to('/'); ?>';
        $("#body-content").load(baseUrl+"/"+url);
    }

    function loadModalEdit(route, id, action){
        var baseUrl='<?php echo URL::to('/'); ?>';
        $("#body-content").load(baseUrl+"/"+ route +'/'+ id +'/'+ action);
    }  

    function editWeekDay(route, id, weekId,action){
        $(".dayHover").css("border-color","black");

 $("#dayHover_"+id+"_"+weekId).css("border-color","red");
        var baseUrl='<?php echo URL::to('/'); ?>';
        $("#body-content").load(baseUrl+"/"+ route +'/'+ id +'/'+ weekId +'/'+action);
    }

      function loadModalLG(url){
        var baseUrl='<?php echo URL::to('/'); ?>';
        $("#body-content-lg").load(baseUrl+"/"+url);
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
                <img src="{{asset('public/images/loading.gif')}}" alt="Loading" title="Loading" height="50px">

            </div>

        </div>
    </div>
</div>
<script>
    $('#modal').on('shown.bs.modal', function () {

    });
</script>

<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"></h4>
      </div>
      <div class="modal-body" id="body-content-lg">
        
      </div>
    
    </div>

  </div>
</div>