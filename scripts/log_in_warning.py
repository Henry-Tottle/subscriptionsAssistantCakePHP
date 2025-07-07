import smtplib
import os
import dotenv
from dotenv import load_dotenv
from email.mime.text import MIMEText
from email.mime.multipart import MIMEMultipart

if os.getenv("RAILWAY_ENVIRONMENT") is None:
    load_dotenv(dotenv_path='config/.env')

def send_login_alert(username: str):
    sender_email = os.getenv('SENDER_EMAIL')
    receiver_email = os.getenv('RECEIVER_EMAIL')
    password = os.getenv('APP_PASSWORD')

    subject = f"Login Alert: {username}"
    body = f"User '{username}' has just logged in to the subscriptions app."

    msg = MIMEMultipart()
    msg['From'] = sender_email
    msg['To'] = receiver_email
    msg['Subject'] = subject

    msg.attach(MIMEText(body, "plain"))

    try:
        with smtplib.SMTP_SSL("smtp.gmail.com", 465) as server:
            server.login(sender_email, password)
            server.sendmail(sender_email, receiver_email, msg.as_string())
        print("Login alert email sent successfully.")
    except Exception as e:
        print(f"Error sending email: {e}")

import sys

if __name__ == "__main__":
    if len(sys.argv) > 1:
        send_login_alert(sys.argv[1])
    else:
        send_login_alert("unknown")