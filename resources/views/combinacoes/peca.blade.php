<x-app-layout>
    <div class="container">
        <h1>Adicionar Peça</h1>
        <form method="POST" action="{{ route('pecas.store') }}" enctype="multipart/form-data">
            @csrf

            <div>
                <label for="cod_comb">Selecione uma Combinação:</label>
                <select name="cod_comb" id="cod_comb">
                    @foreach ($combinacoes as $combinacao)
                        <option value="{{ $combinacao->id }}">{{ $combinacao->id }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="desc_peca">Descrição da Peça:</label>
                <input type="text" name="desc_peca" id="desc_peca" required>
            </div>

            <div>
                <label for="preco_peca">Preço da Peça:</label>
                <input type="text" name="preco_peca" id="preco_peca" required>
            </div>

            <div>
                <label for="img_peca">Imagem da Peça:</label>
                <input type="file" name="img_peca" id="img_peca" required accept="image/*" onchange="previewImage()">
            </div>

            <div>
                <img id="img-preview" src="#" alt="Imagem da peça" width="300" height="300" style="display: none;">
            </div>
<br>
            <div>
                <label for="link_peca">Link da Peça:</label>
                <input type="text" name="link_peca" id="link_peca" required>
            </div>

            <div>
                <button type="submit">Adicionar Peça</button>
            </div>
        </form>
    </div>

        <script>
            function previewImage() {
                var input = document.getElementById('img_peca');
                var preview = document.getElementById('img-preview');

                if (input.files && input.files[0]) {
                    var reader = new FileReader();

                    reader.onload = function(e) {
                        preview.src = e.target.result;
                        preview.style.display = 'block';
                    }

                    reader.readAsDataURL(input.files[0]);
                } else {
                    preview.src = '#';
                    preview.style.display = 'none';
                }
            }
        </script>
</x-app-layout>