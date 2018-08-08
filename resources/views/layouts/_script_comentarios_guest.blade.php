<!-- Toastr -->
<script src="{{ asset('inspinia/js/plugins/toastr/toastr.min.js') }}"></script>
<script>
    $(function () {
        toastr.options = {
            closeButton: true,
            progressBar: true,
            showMethod: 'slideDown',
            timeOut: 4000
        };
        $('#side-menu li.active').removeClass('active');
        var url = jQuery(location).attr('href').split('/')[3];
        $("#side-menu [href='/" + url +"']").parent().parent().parent().parent().parent().addClass('active');
        $("#side-menu [href='/" + url +"']").parent().parent().parent().addClass('active');
        $("#side-menu [href='/" + url +"']").parent().addClass('active');
    });

    $('#guestDataUser').on('show.bs.modal', function (event) {
        var idCampo = $('#guestDataUser').data('idcampo');
        var typeConversation = $('#guestDataUser').data('typeconversation');
        $("#confirmUserData").removeAttr('onclick');
        $('#confirmUserData').attr('onClick', 'registerGuest("'+ typeConversation +'", "'+ idCampo +'");');
    });

    $("#guestDataUser").on('hidden.bs.modal', function () {
        $('#nameguest-error').addClass('hidden');
        $('#emailguest-error').addClass('hidden');
        $('#nameGuest').val('');
        $('#emailGuest').val('');
    });
    
    $('#confirmDeleteConversation').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var conversationId = button.data('conversationid');
        var typeConversation = button.data('typeconversation');
        $("#buttonConfirmDelete").removeAttr('onclick');
        $('#buttonConfirmDelete').attr('onClick', 'deleteConversation("'+ conversationId +'", "'+ typeConversation +'");');
    });

    function deleteConversation(conversationId, typeConversation) {
        @if(Auth::check())
            var url = "/itemsconversations/destroy";
        @else
            var url = "/itemsconversations/destroyGuest";
        @endif
        $.ajax({
            url: url,
            data: {
                "itemConversationId":conversationId,
                "type":typeConversation,
                "_token": "{{ csrf_token() }}"
            },
            dataType: "json",
            method: "POST",
            success: function(result)
            {
                if (result.result === 'delete') {
                    $('.item-' + result.itemConversation.id).remove();
                } else if (result.result === 'update') {
                    $('#item-' + result.itemConversation.id).css('font-style', 'italic');
                    $('#item-' + result.itemConversation.id).html(result.itemConversation.name);
                    $('#time-' + conversationId).html(' - ' + result.time);
                    $('#delete-' + conversationId).remove();
                }
                $('#confirmDeleteConversation').modal('hide'); 
            },
            error: function () {
            //alert("fallo");
            }
        });
    }
    
    
    function agregarComentario(tabla, comentario, tipoComentario, idParent) {
        idRecord = $('#idRecord').val();
        var imagenUsuario = '';
        @if(Auth::check())    
            imagenUsuario = '{{ asset("uploads/avatars/". Auth::user()->avatar) }}';
            var url = "/conversations/store";
            var user = new Object();
        @else
            imagenUsuario = '{{ asset("uploads/avatars/default.jpg") }}';
            var url = "/conversations/storeGuest";
            var user = $('#nameUserGuest').data('user');
        @endif
        $.ajax({
            url: url,
            data: { 
                "table":tabla,
                "id_record":idRecord,
                "comentario":comentario,
                "type":tipoComentario,
                "parent":idParent,
                "user":user,
                "_token": "{{ csrf_token() }}"
                },
            dataType: "json",
            method: "POST",
            success: function(result)
            {
                if (result.type === 'Question') {
                    var answer = "\'Answer\'";
                    var html = '<div class="social-avatar item-'+result.id+'"><a><img alt="image" class="img-circle" src="'+imagenUsuario+'"></a></div>\n\
                    <div class="social-feed-box item-'+result.id+'"><div class="social-avatar"><a href="/profile/user/'+result.user_id+'">'+result.user_name+'</a><small class="text-muted" id="time-'+result.id+'"> - '+result.tiempo+'</small><button type="button" id="delete-'+result.id+'" class="deleteConversation pull-right btn-default" data-toggle="modal" data-target="#confirmDeleteConversation" data-conversationid="'+result.id+'" data-typeconversation="Question" title="Eliminar comentario">×</button></div>\n\
                    <div class="social-body"><p id="item-'+result.id+'">'+result.name+'</p><br><div class="btn-group"><a class="btn btn-white btn-xs" onclick="habilitarComentario('+result.id+')"><i class="fa fa-comments"></i> Comentar</a></div></div><div class="social-footer"><div class="social-comment hidden" id="comentario'+result.id+'"><a class="pull-left"><img alt="image" class="img-circle" src="'+imagenUsuario+'"></a>\n\
                    <div class="media-body"><textarea class="form-control" onkeypress="pulsar(this, event, '+answer+', '+result.id+')" placeholder="Escribe un comentario..." maxlength="250"></textarea></div></div></div></div><div class="hr-line-dashed question-'+result.id+'"></div>';
                    $('#comentario_ultimo').before(html);
                } else if (result.type === 'Answer') {
                    var answer = "\'Answer to Answer\'";
                    var html = '<div class="social-comment item-'+result.id+'"><a class="pull-left"><img alt="image" class="img-circle" src="'+imagenUsuario+'"></a><div class="media-body"><a href="/profile/user/'+result.user_id+'">'+result.user_name+'</a><small class="text-muted" id="time-'+result.id+'"> - '+result.tiempo+'</small><button type="button" id="delete-'+result.id+'" class="deleteConversation pull-right btn-default" data-toggle="modal" data-target="#confirmDeleteConversation" data-conversationid="'+result.id+'" data-typeconversation="AnswerWall" title="Eliminar comentario">×</button>\n\
                    <div id="item-'+result.id+'">'+  result.name+'</div><div class="btn-group"><a class="btn btn-white btn-xs" onclick="habilitarComentario('+result.id+')"><i class="fa fa-comments"></i> Comentar</a></div></div>\n\
                    <div class="social-comment hidden" id="comentario'+result.id+'"><a class="pull-left"> <img alt="image" class="img-circle" src="'+imagenUsuario+'"> </a><div class="media-body"><textarea class="form-control" onkeypress="pulsar(this, event, '+answer+', '+result.id+')" placeholder="Escribe un comentario..." maxlength="250"></textarea></div></div></div>';
                    $('#comentario'+result.parent).before(html);
                } else {
                    var html = '<div class="social-comment item-'+result.id+'"><a class="pull-left"><img alt="image" class="img-circle" src="'+imagenUsuario+'"></a><div class="media-body"><a href="/profile/user/'+result.user_id+'">'+result.user_name+'</a><small class="text-muted" id="time-'+result.id+'"> - '+result.tiempo+'</small><button type="button" id="delete-'+result.id+'" class="deleteConversation pull-right btn-default" data-toggle="modal" data-target="#confirmDeleteConversation" data-conversationid="'+result.id+'" data-typeconversation="AnswerTo" title="Eliminar comentario">×</button>\n\
                    <div>'+  result.name+'</div></div></div>';
                    $('#comentario'+result.parent).before(html);
                }
            },
            error: function () {
               //alert("fallo");
            }
            
        });
    }
    
    function habilitarComentario(idCampo) {
        @if(Auth::check())
            if ($('#comentario'+idCampo).hasClass("hidden")) {
                $('#comentario'+idCampo).removeClass("hidden");
            }
            $('#comentario'+idCampo+' textarea').focus();
        @else
            if ($('#nameUserGuest').val() !== '') {
                if ($('#comentario'+idCampo).hasClass("hidden")) {
                    $('#comentario'+idCampo).removeClass("hidden");
                }
                $('#comentario'+idCampo+' textarea').focus();
            } else {
                $('#guestDataUser').data('typeconversation', 'comment');
                $('#guestDataUser').data('idcampo', idCampo);
                $('#guestDataUser').modal('show');
            }
        @endif
    }

    function registerGuest(typeConversation, idCampo) {
        if ($('#nameGuest').val() === '') {
            $('#nameguest-error').removeClass('hidden');
            return false;
        } else if ($('#emailGuest').val() === '') {
            $('#emailguest-error').removeClass('hidden');
            return false;
        } else {
            $('#nameguest-error').addClass('hidden');
            $('#emailguest-error').addClass('hidden');
            var name = $('#nameGuest').val();
            var email = $('#emailGuest').val();
            $.ajax({
                url: "/registerguest",
                data: { 
                    "name":name,
                    "email":email,
                    "_token": "{{ csrf_token() }}"
                    },
                dataType: "json",
                method: "POST",
                success: function(result)
                {
                    if (result.result !== 'unauthorized') {
                        $('#nameUserGuest').val(result.user.name);
                        $('#nameUserGuest').data().user = result.user;
                        $('#nameGuest').val('');
                        $('#emailGuest').val('');
                        $('#guestDataUser').modal('hide');
                        if (typeConversation === 'comment') {
                            habilitarComentario(idCampo);
                        } else if (typeConversation === 'post') {
                            setTimeout(function(){
                                $('#redactarPublicacion').modal('show');
                            }, 1500);
                        }
                        if (result.result === 'new') {
                            toastr.success('Sigue trabajando.', 'Gracias ' + name + ' tus datos, se han almacenado.');
                        } else if (result.result === 'exists'){
                            toastr.success('Sigue trabajando.', 'Haz vuelto ' + result.user.name + '.');
                        }
                    } else {
                        toastr.warning('Correo registrado.', 'El correo '+ email +' ya existe, debes loguearte.');
                    }
                },
                error: function () {
                //alert("fallo");
                }
            });
        }
    }
</script>