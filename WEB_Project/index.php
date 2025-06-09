<?php session_start();?>
<!DOCTYPE html>
<html>
    <head>
        <title>XML to Emmet and Back</title>
        <link rel="stylesheet" href="style.css"/>
        <meta charset="UTF-8">
    </head>
    <body>
        </header>
            <nav>
                <button onclick="location.href='./index.php'" type="button" class="nav_button">Main</button>
                <button onclick="location.href='./his.php'" type="button" class="nav_button">History</button>
                <button onclick="location.href='./src/logout.php'" type="button" class="nav_button">Logout</button>
            </nav>
        </header>
        <div class="container">
            <form action="./src/transformer.php" method="POST" id="data_form">
                <div>
                    <input type="checkbox" id="mode" name="mode" value="1">
                    <label for="switching"> Emmet to XML</label>
                    <input type="checkbox" id="element_val" name="element_val">
                    <label for="element_val">Get Value Of Elements</label>
                    <input type="checkbox" id="attributes" name="attributes">
                    <label for="attributes">Get Attributes</label>
                    <input type="checkbox" id="attributes_val" name="attributes_val">
                    <label for="attributes_val">Get Attributes Value</label>
                </div>
                <div>
                    <pre id="input" class="input_lable">Input</pre>
                    <?php if (isset($_SESSION['last_input'])) {?>
                        <textarea class="input_box" name="input_box" id="input_box"><?php print_r( $_SESSION['last_input']);?></textarea>  
                    <?php }else{?>
                        <textarea class="input_box" name="input_box" id="input_box" value="aaaa"></textarea>
                    <?php } ?>

                    <pre id="output" class="output_lable">Output</pre>
                    <?php if (isset($_SESSION['last_output'])) {?>
                        <textarea class="output_box" name="output_box" id="output_box"><?php print_r( $_SESSION['last_output']);?></textarea>  
                    <?php }else{?>
                        <textarea class="output_box" name="output_box" id="output_box"></textarea>
                    <?php } ?>
                    
                </div>
                <button type="submit" class="submit_button">Convert</button>
                <?php if (isset($_GET['error'])) { ?>
                    <p class="error">Error: <?php echo $_GET['error']; ?></p>
                <?php } ?>
            </form>
        </div>

    </body>
</html>