<?php
class FeedbackModel
{
    private static $message = '';

    /**
     * Present the user with feedback
     *
     * @return string
     */
    public function presentFeedback(): string
    {
        return self::$message;
    }
}
