<?php
echo password_hash(uniqid("zten_".mt_rand()), PASSWORD_DEFAULT);

