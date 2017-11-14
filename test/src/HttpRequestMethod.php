<?php

use Eloquent\Enumeration\AbstractEnumeration;

final class HttpRequestMethod extends AbstractEnumeration
{
    const OPTIONS = 'OPTIONS';
    const GET = 'GET';
    const HEAD = 'HEAD';
    const POST = 'POST';
    const PUT = 'PUT';
    const DELETE = 'DELETE';
    const TRACE = 'TRACE';
    const CONNECT = 'CONNECT';
}
