<?php

session_abort();
session_cache_expire();
session_cache_limiter();
session_commit();
session_decode($data);
session_destroy();
session_encode();
session_get_cookie_params();
session_id();
session_is_registered('foo');
session_module_name();
session_name();
session_regenerate_id();
session_register_shutdown();
session_register('bar');
session_reset();
session_save_path();
session_set_cookie_params(3600);
session_set_save_handler(function () {
    // nothing here
});
session_start();
session_status();
session_unregister('baz');
session_unset();
session_write_close();

$sessionNope();
