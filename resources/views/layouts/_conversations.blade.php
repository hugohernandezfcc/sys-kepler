<div class="social-feed-separated">
    @foreach ($comments as $conversations)
    <div class="social-avatar question-{{ $conversations['Question']->id }}">
        <a href=""><img alt="image" class="img-circle" src="{{ asset('uploads/avatars/'. $conversations['Question']->user->avatar) }}"></a>
    </div>
    <div class="social-feed-box question-{{ $conversations['Question']->id }}">
        <div class="social-avatar">
            <a href="/profile/user/{{ $conversations['Question']->user->id }}">{{ $conversations['Question']->user->name }}</a><small class="text-muted"> - {{ $conversations['Question']->created_at->diffForHumans() }}</small>
            @if ($conversations['Question']->user->id === Auth::user()->id)
                <span class="deleteConversation pull-right" onclick="deleteConversation('question-{{ $conversations['Question']->id }}', {{ $conversations['Question']->id }})">×</span>
            @endif
        </div>
        <div class="social-body">
            <p id="question-{{ $conversations['Question']->id }}">{{ $conversations['Question']->name }}</p><br>
            <div class="btn-group">
                <a class="btn btn-white btn-xs" onclick="habilitarComentario({{ $conversations['Question']->id }})"><i class="fa fa-comments"></i> Comentar</a>
            </div>
        </div>
        <div class="social-footer">
            @if (count($conversations['Answer'][0]) > 0)
            @foreach ($conversations['Answer'][0] as $itemConversation)
            <div class="social-comment">
                <a href="" class="pull-left"><img alt="image" class="img-circle" src="{{ asset('uploads/avatars/'. $itemConversation->user->avatar) }}"></a>
                <div class="media-body">
                    <a href="/profile/user/{{ $itemConversation->user->id }}">{{ $itemConversation->user->name }}</a>  {{ $itemConversation->name }}<br>
                    <div class="btn-group">
                        <a class="btn btn-white btn-xs" onclick="habilitarComentario({{ $itemConversation->id }})"><i class="fa fa-comments"></i> Comentar</a> - <small class="text-muted">{{ $itemConversation->created_at->diffForHumans() }}</small>
                    </div>
                </div>

                @if (count($itemConversation['AnswerToAnswer']) > 0)
                @foreach ($itemConversation['AnswerToAnswer'] as $itemAnswer)
                <div class="social-comment">
                    <a href="" class="pull-left"><img alt="image" class="img-circle" src="{{ asset('uploads/avatars/'. $itemAnswer->user->avatar) }}"></a>
                    <div class="media-body">
                        <a href="/profile/user/{{ $itemAnswer->user->id }}">{{ $itemAnswer->user->name }}</a> {{ $itemAnswer->name }}<br><small class="text-muted">{{ $itemAnswer->created_at->diffForHumans() }}</small>
                    </div>
                </div>
                @endforeach
                @endif

                <div class="social-comment hidden" id="comentario{{ $itemConversation->id }}">
                    <a href="" class="pull-left"> <img alt="image" class="img-circle" src="{{ asset('uploads/avatars/'. Auth::user()->avatar) }}"> </a>
                    <div class="media-body">
                        <textarea class="form-control" onkeypress="pulsar(this, event, 'Answer to Answer', {{ $itemConversation->id }})" placeholder="Escribe un comentario..."></textarea>
                    </div>
                </div>
            </div>

            @endforeach
            @endif
            <div class="social-comment hidden" id="comentario{{ $conversations['Question']->id }}">
                <a href="" class="pull-left"><img alt="image" class="img-circle" src="{{ asset('uploads/avatars/'. Auth::user()->avatar) }}"></a>
                <div class="media-body">
                    <textarea class="form-control" onkeypress="pulsar(this, event, 'Answer', {{ $conversations['Question']->id }})" placeholder="Escribe un comentario..."></textarea>
                </div>
            </div>
        </div>
    </div>

    <div class="hr-line-dashed question-{{ $conversations['Question']->id }}"></div>

    @endforeach 

    <div id='ultimo_comentario'>
        <div class="social-avatar">
            <a href=""><img alt="image" class="img-circle" src="{{ asset('uploads/avatars/'. Auth::user()->avatar) }}"></a>
        </div>
        <div class="media-body">
            <textarea class="form-control" onkeypress="pulsar(this, event, 'Question', null)" placeholder="Escribe un comentario..."></textarea>
        </div>
    </div>
</div>

<script>
    function deleteConversation(idTexto, idConversation) {
        if (true) {
            $('.' + idTexto).remove();
        }
    }
</script>