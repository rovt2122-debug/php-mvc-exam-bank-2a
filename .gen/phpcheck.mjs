// Sanity check sederhana untuk file PHP: keseimbangan brace/kurung/quote
// di luar string & komentar. Tidak menggantikan php -l, tapi menangkap
// kesalahan sintaks kasar (brace kurang, string tidak ditutup, dll).
import { readFileSync, readdirSync, statSync } from 'fs';
import { join } from 'path';

const ROOT = '/vercel/share/v0-project/php-mvc-exam-bank';
const files = [];
(function walk(dir) {
  for (const name of readdirSync(dir)) {
    const p = join(dir, name);
    const s = statSync(p);
    if (s.isDirectory()) walk(p);
    else if (name.endsWith('.php')) files.push(p);
  }
})(ROOT);

let bad = 0;
for (const file of files) {
  const src = readFileSync(file, 'utf8');
  // hanya bagian di dalam <?php ... ?> atau file full-php
  let code = '';
  if (src.includes('<?php')) {
    const re = /<\?php([\s\S]*?)(\?>|$)/g;
    let m;
    while ((m = re.exec(src))) code += m[1] + '\n';
  } else {
    code = src;
  }

  const stack = [];
  let i = 0, line = 1, err = null, inStr = null;
  while (i < code.length && !err) {
    const c = code[i], n = code[i + 1];
    if (c === '\n') { line++; i++; continue; }
    if (inStr) {
      if (c === '\\') { i += 2; continue; }
      if (c === inStr) inStr = null;
      if (c === '\n') line++;
      i++; continue;
    }
    if (c === "'" || c === '"') { inStr = c; i++; continue; }
    if (c === '/' && n === '/') { while (i < code.length && code[i] !== '\n') i++; continue; }
    if (c === '#') { while (i < code.length && code[i] !== '\n') i++; continue; }
    if (c === '/' && n === '*') { i += 2; while (i < code.length && !(code[i] === '*' && code[i + 1] === '/')) { if (code[i] === '\n') line++; i++; } i += 2; continue; }
    if (c === '{' || c === '(' || c === '[') { stack.push({ c, line }); i++; continue; }
    if (c === '}' || c === ')' || c === ']') {
      const open = { '}': '{', ')': '(', ']': '[' }[c];
      const top = stack.pop();
      if (!top || top.c !== open) { err = `line ${line}: '${c}' tanpa pasangan '${open}'`; break; }
      i++; continue;
    }
    i++;
  }
  if (!err && inStr) err = `string '${inStr}' tidak ditutup`;
  if (!err && stack.length) err = `'${stack[stack.length - 1].c}' buka di line ${stack[stack.length - 1].line} tidak ditutup`;
  if (err) { bad++; console.log(`FAIL ${file.replace(ROOT + '/', '')}: ${err}`); }
}
console.log(`\n${files.length - bad}/${files.length} file PHP lolos sanity check`);
process.exit(bad ? 1 : 0);
