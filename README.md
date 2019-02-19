# Civilization VI turn notification

This script allows you to send notifications to players in your Civilization VI Play by Cloud game of the pending turn. The script currently allows for Slack, Nexmo SMS and email notifications.

The setup is fairly simple. You need to host the script in a PHP-capable HTTP server that doesn't force HTTPS. Add a config.php which maps player names to email addresses, Slack ID's etc. and start a game.

There seem to be some kinks in the webhook process of the game. If the webhook URL is secure (https), the request is made but doesn't contain any data. Additionally changing the webhook URL in your Civ 6 settings doesn't seem to effect right away, but only after you've played your next turn – it's perhaps included in the turn file.
