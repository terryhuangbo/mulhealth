<?php
Yii::setAlias('common', dirname(__DIR__));
Yii::setAlias('frontend', dirname(dirname(__DIR__)) . '/frontend');
Yii::setAlias('backend', dirname(dirname(__DIR__)) . '/backend');
Yii::setAlias('console', dirname(dirname(__DIR__)) . '/console');
Yii::setAlias('environment', dirname(dirname(__DIR__)) . '/environment');
Yii::setAlias('front', 'http://www.mulhealth.com');
Yii::setAlias('back', 'http://www.mulhealth_back.com');
Yii::setAlias('upload', '@front/file-upload');
Yii::setAlias('delfile', '@front/file-delete');
