<?php $lines = explode('\n', $message); ?>

<section>
    <h3>Dear <?= ucwords($receiver); ?>,</h3>
    <div>
        <p>I hope everything is going well for you!</p>
        <p>Thank you very much for commenting on my post: <?= $postTitle; ?>.</p>
        <p>I appreciate your interests in my work, and I will be happy to see you come back to my blog in a near future. Your comment will help me a lot in later researches.</p>
        <p>Should you have any queries or wish to contact me further, please do not hesitate to reply to this email.</p>
        <p>Please find below the content of your comment.</p>

        <blockquote style="border-left: 5px solid #CCC; background-color: #F9F9F9; padding-left: 10px;">
            <?php foreach ($lines as $line): ?>
                <p><?= $this->Text->autoParagraph($line); ?></p>
            <?php endforeach; ?>
        </blockquote>

        <br><p>Kind regards,</p>

        <p>Le Kim Phuc Nguyen (Jay)<br>
            Monash Professional Pathways (Feb 2018)<br>
            Tel: <a href="tel:+61422357488">(+61) 422 357 488</a><br>
            Website: <a href="www.jaydeveloper.com">www.jaydeveloper.com</a></p>
    </div>
</section>
