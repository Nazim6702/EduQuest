<?php
namespace App\Enum;

enum QuestionType: string {
    case QCM = 'QCM';
    case TRUE_FALSE = 'True/False';
    case OPEN = 'Open';
}
