<!-- Toastr -->
<script src="{{ asset('inspinia/js/plugins/toastr/toastr.min.js') }}"></script>
<script>
    $(function () {
        if (sessionStorage.getItem('user') !== null) {
            let user = JSON.parse(sessionStorage.getItem('user'));
            $('.text-muted.welcome-message').html('Bienvenido ' + user.name);
            $('#nameUserGuest').val(user.id);
            $('#nameUserGuest').data().user = user;
        }
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
                        sessionStorage.setItem('user', JSON.stringify(result.user));
                        $('.text-muted.welcome-message').html('Bienvenido ' + result.user.name);
                        $('#nameUserGuest').val(result.user.id);
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
                        } else if (typeConversation === 'question') {
                            setTimeout(function(){
                                $('#redactarPregunta').modal('show');
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