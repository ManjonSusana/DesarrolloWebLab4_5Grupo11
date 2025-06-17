
<!DOCTYPE html>
<html lang="en">
<head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
</head>
<body>

        <form method="post" id="datos-persona">
                <div class="mb-3">
                <label for="exampleInputEmail1" for="correos" class="form-label">Correo</label>
                <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="correos" id="correos">
                </div>

                <div class="mb-3">
                <label for="exampleInputEmail1" for="asuntos" class="form-label">Asunto</label>
                <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="asuntos" id="asuntos">
                </div>

                <div class="mb-3">
                <label for="exampleInputEmail1" for="mensajes" class="form-label">Mensaje</label>
                <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="mensajes" id="mensajes">
                </div>
                

                <button type="submit" class="btn btn-primary" value="Enviar" onclick="crearcorreo()">Enviar</button>
                <button type="submit" class="btn btn-primary" value="Guardar" onclick="guardar()">Guardar</button>
        </form>
        
</body>
</html>
