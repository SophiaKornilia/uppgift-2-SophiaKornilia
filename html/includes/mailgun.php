curl -s --user 'api:2fe1fadd69a04e7093aab6d8b6c943e5-32a0fef1-6042ebe0' \
https://api.mailgun.net/v3/sandbox26ef209e49264bbca8ce50646f208f76.mailgun.org/messages \
-F from='Excited User <mailgun@YOUR_DOMAIN_NAME>' \
    -F to=YOU@YOUR_DOMAIN_NAME \
    -F to=bar@example.com \
    -F subject='Hello' \
    -F text='Testing some Mailgun awesomeness!'