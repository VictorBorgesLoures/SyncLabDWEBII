<?php
return isset($_SESSION['__flash']['error']) ? flash('error') : flash('message');
