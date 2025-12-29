<?php

Class TenantContext {
    public static function id():int
    {
        return auth()->user()->tenant_id;
    }
}