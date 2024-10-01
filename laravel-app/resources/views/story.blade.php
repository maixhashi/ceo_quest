<div>
    <p><strong>{{ $story['character'] }}:</strong> {{ $story['text'] }}</p>
    
    @if(!empty($story['choices']))
        <form action="{{ route('story.progress') }}" method="POST">
            @csrf
            @foreach($story['choices'] as $choice)
                <button type="submit" name="next_story_id" value="{{ $choice['next'] }}">
                    {{ $choice['character'] }}: {{ $choice['text'] }}
                </button>
            @endforeach
        </form>
    @elseif($hasNext)
        <form action="{{ route('story.progress') }}" method="POST">
            @csrf
            <button type="submit" name="next_story_id" value="{{ $story['next'] }}">次へ</button>
        </form>
    @else
        <p>ストーリーは終了しました。</p>
    @endif

    <!-- リセットボタン -->
    <form action="{{ route('story.reset') }}" method="POST">
        @csrf <!-- CSRFトークンを追加 -->
        <button type="submit">リセット</button>
    </form>
</div>

    