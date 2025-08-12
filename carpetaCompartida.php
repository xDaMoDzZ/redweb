<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>📁 Compartir Archivos</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f4f4f9;
            margin: 0;
            padding: 40px;
        }

        .container {
            max-width: 800px;
            margin: auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }

        h1 {
            text-align: center;
            color: #333;
        }

        h2 {
            color: #2c3e50;
            border-bottom: 1px solid #ddd;
            padding-bottom: 10px;
        }

        form {
            margin: 15px 0;
        }

        input[type="file"] {
            padding: 8px;
        }

        button {
            background-color: #3498db;
            color: white;
            padding: 8px 14px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-left: 10px;
        }

        button:hover {
            background-color: #2980b9;
        }

        ul {
            list-style: none;
            padding: 0;
        }

        li {
            padding: 10px;
            margin: 5px 0;
            background: #ecf0f1;
            border-radius: 5px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        a {
            color: #2c3e50;
            text-decoration: none;
        }

        .actions form {
            display: inline;
        }

        .trash {
            color: #e74c3c;
        }

        .restore {
            background-color: #2ecc71;
        }

        .restore:hover {
            background-color: #27ae60;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>📁 Compartir Archivos en Red</h1>

    <h2>Subir archivo</h2>
    <form id="upload-form">
        <input type="file" name="upload" required>
        <button type="submit">Subir</button>
    </form>

    <div id="file-lists">Cargando archivos...</div>

    <h2>📝 Notas en tiempo real</h2>
    <textarea id="live-notes" rows="10" style="width:100%; resize: vertical;" placeholder="Escribe tus notas aquí..."></textarea>
</div>

<script>
const textarea = document.getElementById('live-notes');
let lastFetched = '';

// Cargar contenido al iniciar
function fetchNotes() {
    fetch('leerNotas.php')
        .then(res => res.text())
        .then(text => {
            if (text !== lastFetched) {
                textarea.value = text;
                lastFetched = text;
            }
        });
}


// Guardar notas automáticamente al escribir
textarea.addEventListener('input', () => {
    fetch('guardarNotas.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: 'contenido=' + encodeURIComponent(textarea.value)
    });
});

// Recargar notas cada 2 segundos
setInterval(fetchNotes, 2000);

fetchNotes(); // cargar inicialmente


    function cargarArchivos() {
        fetch('listarArchivos.php')
            .then(res => res.text())
            .then(html => {
                document.getElementById('file-lists').innerHTML = html;
                asignarEventos(); // volver a asignar eventos
            });
    }

    function asignarEventos() {
        document.querySelectorAll('.delete-btn').forEach(btn => {
            btn.onclick = e => {
                e.preventDefault();
                fetch('eliminar.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: 'file=' + encodeURIComponent(btn.dataset.file)
                }).then(() => cargarArchivos());
            };
        });

        document.querySelectorAll('.restore-btn').forEach(btn => {
            btn.onclick = e => {
                e.preventDefault();
                fetch('restaurar.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: 'file=' + encodeURIComponent(btn.dataset.file)
                }).then(() => cargarArchivos());
            };
        });
    }

    document.getElementById('upload-form').addEventListener('submit', function (e) {
        e.preventDefault();
        const formData = new FormData(this);
        fetch('subir.php', {
            method: 'POST',
            body: formData
        }).then(() => {
            this.reset();
            cargarArchivos();
        });
    });

    cargarArchivos();
    setInterval(cargarArchivos, 2000);
</script>
</body>
</html>
