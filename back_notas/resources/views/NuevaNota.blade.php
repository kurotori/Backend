<div>
    <!-- It is quality rather than quantity that matters. - Lucius Annaeus Seneca -->

    <form action="/api/nota/nueva" method="post">
        @csrf
        <label for="titulo">Titulo:</label>
        <input type="text" id="titulo" name="titulo">
        <br>
        <label for="titulo">Texto:</label>
        <input type="text" id="texto" name="texto">
        <button type="submit">Enviar</button>
    </form>
</div>
