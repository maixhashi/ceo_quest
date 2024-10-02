<div>
    <p><strong>{{ $story['character'] }}:</strong> {{ $story['text'] }}</p>

    @if(isset($story['showForm']) && $story['showForm'])
    <div class="nes-container w-full is-dark is-rounded text-center" 
         style="border-image-repeat: stretch; width: 80%; margin: 15% auto; padding: 20px;">
        <link rel="stylesheet" href="https://unpkg.com/nes.css/css/nes.min.css">
        <h3 class="modal-title" style="text-align: center;">会社名は？</h3>
        <form action="{{ route('story.saveCompanyName') }}" method="POST" id="companyForm">
            @csrf
            <label for="company_name">「会社名は‥</label>
            <input type="text" id="company_name" name="company_name" class="form-control nes-input" required>
            <span>だ！」</span>
        </form>
        <div style="text-align: center;">
            <button type="submit" class="nes-btn is-primary mt-3" form="companyForm">決定!</button>
        </div>
    </div>
    @endif

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

<style>
.nes-dialog {
  position: fixed;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  z-index: 101;
}

#fullOverlay{
  position: fixed;
  left: 0; 
  top: 0;
  width: 100%; 
  height: 100%;
  background: rgba(100, 100, 100, .8);
  z-index: 100;
}

@media only screen and (max-width: 767px) {
    .nes-dialog {
        width: 100%;	
        text-align: left;
    }
}
</style>
