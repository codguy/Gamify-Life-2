<?php

/** @var yii\web\View $this */
/** @var string $name */
/** @var string $message */
/** @var Exception $exception */

use yii\helpers\Html;

$this->title = $name;
?>
<div class="site-error">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="alert alert-danger">
        <?= nl2br(Html::encode($message)) ?>
    </div>

    <p>
        The above error occurred while the Web server was processing your request.
    </p>
    <p>
        Please contact us if you think this is a server error. Thank you.
    </p>
    <!-- Error Page View -->
    <div id="error-page" class="view">
        <div class="min-h-screen flex items-center justify-center">
            <div class="text-center">
                <div class="mb-8">
                    <div class="text-9xl font-bold text-gray-300">404</div>
                    <div class="text-2xl font-semibold text-gray-600 mb-4">Oops! Quest not found</div>
                    <p class="text-gray-500 mb-8">The page you're looking for has vanished into the digital
                        realm.</p>
                </div>

                <div class="space-x-4">
                    <button onclick="showView('dashboard')"
                        class="bg-blue-500 text-white px-6 py-3 rounded-lg hover:bg-blue-600">
                        <i class="fas fa-home mr-2"></i>Return to Dashboard
                    </button>
                    <button class="bg-gray-200 text-gray-700 px-6 py-3 rounded-lg hover:bg-gray-300">
                        <i class="fas fa-envelope mr-2"></i>Report Issue
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>