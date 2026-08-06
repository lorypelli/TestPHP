from pathlib import Path

src = Path('./.env.example')
dest = Path('./.env')
htpasswd = Path('./nginx/.htpasswd')
htpasswdsh = Path('./nginx/htpasswd.sh')

if not(src.exists()) or not(htpasswdsh.exists()):
    print('\x1b[1;31m[ERROR]\x1b[0m Missing required files!')
    raise SystemExit(1)

if not(dest.exists()):
    dest.write_bytes(src.read_bytes())

htpasswd.touch(0o644)

src.chmod(0o644)
dest.chmod(0o644)

htpasswdsh.chmod(0o755)

print('\x1b[1;32m[SUCCESS]\x1b[0m Setup completed!')
print('\x1b[1;33m[WARN]\x1b[0m Make sure env values are not empty!')
