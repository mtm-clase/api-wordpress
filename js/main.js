const url = 'http://wordpress-api.ingeniero.cierva/php/controller.php';

async function uploadPost() {
    const title=document.getElementById('title').value;
    const content=document.getElementById('content').value;

    if (!title || !content) alert('Por favor, introduce un valor.');

    const json_request= {'title': title, 'content': content};

    const request = new Request(url, {
        method: "POST",
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(json_request)}
    )

    const response = await fetch(request);
    if (response.status == 200) alert('Contenido subido con éxito.');
    console.log(await response.text());
}