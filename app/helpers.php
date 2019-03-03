<?php

function get_notification()
{
    return session('notification');
}

function get_error()
{
    return session('error');
}
