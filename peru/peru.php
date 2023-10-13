<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PERU</title>
</head>

<style>
    #feedback-form {
        width: 280px;
        margin: 0 auto;
        background-color: #fcfcfc;
        padding: 20px 50px 40px;
        box-shadow: 1px 4px 10px 1px #aaa;
        font-family: sans-serif;
    }

    #feedback-form * {
        box-sizing: border-box;
    }

    #feedback-form h2 {
        text-align: center;
        margin-bottom: 30px;
    }

    #feedback-form input {
        margin-bottom: 15px;
    }

    #feedback-form textarea {
        margin-bottom: 15px;
        width: 280px;
        resize: none;
    }

    #feedback-form input[type=text] {
        display: block;
        height: 32px;
        padding: 6px 16px;
        width: 100%;
        border: none;
        background-color: #f3f3f3;
    }

    #feedback-form input[type=number] {
        display: block;
        height: 32px;
        padding: 6px 16px;
        width: 100%;
        border: none;
        background-color: #f3f3f3;
    }

    #feedback-form label {
        color: #777;
        font-size: 0.8em;
    }

    #feedback-form button[type=submit] {
        display: block;
        margin: 20px auto 0;
        width: 150px;
        height: 40px;
        border-radius: 25px;
        border: none;
        color: #eee;
        font-weight: 700;
        box-shadow: 1px 4px 10px 1px #aaa;

        background: #207cca;
        /* Old browsers */
        background: -moz-linear-gradient(left, #207cca 0%, #9f58a3 100%);
        /* FF3.6-15 */
        background: -webkit-linear-gradient(left, #207cca 0%, #9f58a3 100%);
        /* Chrome10-25,Safari5.1-6 */
        background: linear-gradient(to right, #207cca 0%, #9f58a3 100%);
        /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
        filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#207cca', endColorstr='#9f58a3', GradientType=1);
        /* IE6-9 */
    }
</style>

<body>
    <div id="feedback-form">
        <h2>PERU - Cadastro de Localizações</h2>

        <form action="">
            <input type="text" name="name" placeholder="Nome"></input>
            <input type="text" name="contact" placeholder="Contato"></input>
            <input type="text" name="opening_hours" placeholder="Horários"></input>
            <textarea id="message" name="description" placeholder="Descição do Local" rows="4" cols="35"></textarea>
            <input type="number" name="latitude" placeholder="Latitude"></input>
            <input type="number" name="longitude" placeholder="Longitude"></input>
            <button type="submit">Registrar</button>
        </form>
    </div>
</body>

</html>