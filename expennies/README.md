# Session Based Authentication

- Session Hijacking 会话劫持攻击
- Session Fixation 会话固定攻击

There are few solutions to solve above two attacks:

- secure connection, http-only
- XSS Protection
- Regenerate SESSION ID `session_regenerate_id()`
