        
            <footer>
                <p class="copyright">&copy; <?php echo date("Y"); ?> Early Learning</p>
                
                <h1><?php 
                if(isset($_SESSION['User']) && isset($_SESSION['ParentID']))
                    echo 'Welcome '.$_SESSION['User'].' UserID: '.$_SESSION['ParentID'];
                else 
                    echo '';
                   ?></h1>
                
                
            </footer>
        </main>
    </body>
</html>

