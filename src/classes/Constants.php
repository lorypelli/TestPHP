<?php
abstract class Constants
{
    public const int MAX_EMAIL_LENGTH = 255;
    public const int MAX_PASSWORD_LENGTH = 60;
    public const int MAX_CODE_LENGTH = 6;
    public const int MAX_NAME_LENGTH = 15;
    public const int MAX_DESCRIPTION_LENGTH = self::MAX_NAME_LENGTH * 6;
}
