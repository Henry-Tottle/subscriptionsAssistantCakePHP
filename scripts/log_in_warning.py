import smtplib
import os
import dotenv
from dotenv import load_dotenv
from email.mime.text import MIMEText
from email.mime.multipart import MIMEMultipart

if os.getenv("RAILWAY_ENVIRONMENT") is None:
    load_dotenv(dotenv_path='config/.env')

LOG_PATH = os.path.join(os.path.dirname(__file__), "logins.txt")

def send_daily_report():
    if not os.path.exists(LOG_PATH):
        print("No logins file found")
        return
    with open(LOG_PATH, 'r') as file:
        content = file.read().strip()

    if not content:
        print("No logins to report today.")
        return
    
    sender = os.getenv("SENDER_EMAIL")
    receiver = os.getenv("RECEIVER_EMAIL")
    password = os.getenv("APP_PASSWORD")

    msg = MIMEText(f"Daily login summary:\n\n{content}")
    msg['Subject'] = "Daily Login Report Subscriptions Assistant"
    msg["From"] = sender
    msg["To"] = receiver

    try:
        with smtplib.SMTP_SSL("smtp.gmail.com", 465) as server:
            server.login(sender, password)
            server.sendmail(sender, receiver, msg.as_string())

        print("Report sent successfuly.")
        open(LOG_PATH, "w").close()
    except Exception as e:
        print(f"Error sending report: {e}")

if __name__ == "__main__":
    send_daily_report()