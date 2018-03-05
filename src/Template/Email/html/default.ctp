<?php $lines = explode('\n', $message); ?>

<section>
    <h3>Dear <?= $receiver ? ucwords($receiver) : 'Guest'; ?>,</h3>
    <div>
        <p>I hope everything is going well for you!</p>

        <?php if ($form) { ?>
        <p>Thank you very much for suggesting me some ideas on my blog posts.
            Your suggestions will help me a lot in finding and repairing the shortcomings of my researches and personal projects.</p>
        <?php } else {?>
        <p>Thank you very much for contacting me from my blog.
            Your email has arrived in my inbox and I will get back to you very soon.</p>
        <?php } ?>

        <p>I appreciate your interests in my work, and I will be happy to see you come back to my blog in a near future.</p>

        <?php if ($form) { ?>
        <p>Should you have any queries or wish to contact me further, please do not hesitate to reply to this email.</p>

        <p>Please find below the content of your <?= $form ? 'suggestion' : 'message'?>.</p>

        <blockquote style="border-left: 5px solid #CCC; background-color: #F9F9F9; padding-left: 10px;">
            <?php foreach ($lines as $line): ?>
                <p><?= $this->Text->autoParagraph($line); ?></p>
            <?php endforeach; ?>
        </blockquote>
        <?php } else { ?>
        <p>Jay usually responds to emails within 30 minutes. If you wish to talk to him in person, please look for his phone number at the signature.</p>
        <?php } ?>

        <br><p>Kind regards,</p>

        <p>Le Kim Phuc Nguyen (Jay)<br>
            Monash Professional Pathways (Feb 2018)<br>
            Tel: <a href="tel:+61422357488">(+61) 422 357 488</a><br>
            Website: <a href="www.jaydeveloper.com">www.jaydeveloper.com</a></p>
    </div>
</section>
