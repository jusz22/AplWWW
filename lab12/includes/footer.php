<footer>
    <div id="zegarek" class="grouped"></div>
    <div id="data" class="grouped"></div>
    <form>
        <input type="text" name="color" id="color" placeholder="hex value">
        <input type="button" value="changeBackground" onclick="changeBackground(document.getElementById('color').value);">
        <input type="button" value="clear" onclick="clearBackground()">
    </form>
    <p id="contact">Contact: <a href="mailto:169250@student.uwm.edu.pl">169250@student.uwm.edu.pl</a></p>
    <p>&#169; <?php echo date('Y'); ?> Jan Juszkiewicz</p>
</footer>
</body>
</html>