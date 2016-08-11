<!-- Modal -->
<div id="{{$modal_id}}" class="modal fade" role="dialog">
     <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title modal_title text-capitalize"></h4>
            </div>
            <div class="modal-body">
                <!-- <p class="danger text-center">Error apa gitu</p> -->
                {!! Form::open(['url' => $modal_route,'method' => 'DELETE', 'class' => 'modal1']) !!}
                    {!! Form::input('hidden', 'id', NULL,  
                            ['class' => 'mod_id']
                    ) !!}   
                    <div class="form-group">
                        <p>Isikan password Anda untuk konfirmasi.</p>
                    </div>                  
                    <div class="form-group">
                        <label for="pwd">Password</label>
                        {!! Form::Password('password', [
                                    'class'        => 'form-control mod_pwd',
                                    'required'     => 'required', 
                                    'tabindex'     => '1'
                        ]) !!}
                    </div>
                	</br>
                    <div class="form-group">
                        <button type="submit" class="btn btn-md btn-block btn-danger" tabindex="1">{{ isset($custom['caption_yes']) ? $custom['caption_yes'] : 'Delete'}}</button>
                    </div>
                    <div class="form-group">
                        <button type="button" class="btn btn-md btn-block btn-default" tabindex="1" data-dismiss="modal">{{ isset($custom['caption_no']) ? $custom['caption_no'] : 'Batal' }}</button>
                    </div>    
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>

@section('scripts')
    $('#{{$modal_id}}').on('show.bs.modal', function (e) {
        var id      = $(e.relatedTarget).attr('data-id');
        var title   = $(e.relatedTarget).attr('data-title');
        var action  = $(e.relatedTarget).attr('data-action');

        $('.mod_pwd').val('');
        $('.mod_id').val(id);
        $('.modal_title').html(title);
        $('.modal1').attr('action', action);
    }); 

    $('#{{$modal_id}}').on('shown.bs.modal', function () {
        $('.mod_pwd').focus();
    });    
@append
