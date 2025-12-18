module.exports = {
  parserOpts: {
    headerPattern: /^\[(.*?)\]\s+(.*)$/,
    headerCorrespondence: ['type', 'subject']
  },
  writerOpts: {
    transform: (commit) => {
      const newCommit = { ...commit };

      const match = newCommit.header.match(/^\[(.*?)\]\s+(.*)$/);

      if (typeof newCommit.hash === 'string') {
        newCommit.shortHash = newCommit.hash.substring(0, 7);
      }

      if (match) {
        // match[1] adalah konteks di dalam [ ]
        // match[2] adalah deskripsinya
        newCommit.section = match[1].toUpperCase();
        newCommit.subject = match[2];
        return newCommit;
      }

      // Jika tidak cocok format [ ], kembalikan null agar tidak masuk changelog
      return null;
    }
  }
};
