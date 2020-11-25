apollonas->apolonas
Import other wordlists and mutate.

Filter out greek: 
    - grep -v -P "[^\x00-\x7F]" output > output_clean
    
Filter out long lines:
    - sed '/^.\{18\}./d' words.txt > words_clean.txt