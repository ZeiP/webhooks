# Civilization VI turn notification

This script allows you to send notifications to players in your Civilization VI Play by Cloud game of the pending turn. The script currently allows for Slack, Nexmo SMS and email notifications. As an added bonus, you can use the same webhook script to send notifications of [Play Your Damn Turn](http://playyourdamnturn.com/) turns. So that's two birds with one stone!

The setup is fairly simple. You need to host the script in a PHP-capable HTTP server that doesn't force HTTPS. Add a config.php which maps player names to email addresses, Slack ID's etc. (based on the example file provided), correct the config.php path if necessary and start a game. 

There seem to be some kinks in the webhook process of the game. If the webhook URL is secure (https), the request is made but doesn't contain any data. Additionally changing the webhook URL in your Civ 6 settings doesn't seem to effect right away, but only after you've played your next turn – it's perhaps included in the turn file.

If you want to use the Slack integration, you need to [create a Slack application](https://api.slack.com/apps/new) and add a bot user to it. Then just set the bot access key to config.php and you should be set!
