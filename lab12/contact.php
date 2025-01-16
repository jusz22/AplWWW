<?php
function PokazKontakt() {
    $formularz = '
    <!DOCTYPE html>
    <html>
    <head>
        <link rel="stylesheet" href="styles/styles_contact.css">
    </head>
    <body>
        <form method="POST" action="includes/contact.php">
            <div>
                <label for="imie">Imię:</label>
                <input type="text" id="imie" name="imie" required>
            </div>
            <div>
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div>
                <label for="temat">Temat:</label>
                <input type="text" id="temat" name="temat" required>
            </div>
            <div>
                <label for="wiadomosc">Wiadomość:</label>
                <textarea id="wiadomosc" name="wiadomosc" required></textarea>
            </div>
            <div>
                <button type="submit" name="wyslij_kontakt">Wyślij wiadomość</button>
            </div>
        </form>
    
    </body>
    </html>
    ';
    
    return $formularz;
}
echo PokazKontakt();
?>

